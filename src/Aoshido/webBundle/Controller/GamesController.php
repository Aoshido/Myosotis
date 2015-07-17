<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\webBundle\Form\PreguntaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;

class GamesController extends Controller {

    public function searchAction(Request $request, $_format) {

        $arrayRolesPermitidos = array('ADMIN_CDP', 'ADMIN_COMPRAS', 'COMPRADOR');
        $resultado = $this->get('session_checker')->check($request, $arrayRolesPermitidos);

        if ($resultado != "") {
            return $resultado;
        }

        $arrayPermisos = $this->get('session_checker')->getPermisosDesdeRoles($_SESSION['roles']);

        $searched = false;
        $registros = array();

        $em = $this->getDoctrine()->getManager();
        $form = $this->get('form.factory')->create(new BusquedasOrdenesCompraFilterType());
        if ($request->isMethod('GET')) {
            $form->handleRequest($request);
            if ($request->get("submit-filter")) {
                $searched = true;
                $filterBuilder = $em
                        ->getRepository('LanClSiteBundle:OrdenesCompra')
                        ->createQueryBuilder('o')
                        ->leftJoin('o.idmoneda', 'm')
                        ->leftJoin('o.idproveedor', 'p')
                        ->leftJoin('o.idocEstado', 'e')
                        ->leftJoin('o.idusuarioComprador', 'u')
                        ->leftJoin('LanClSiteBundle:UsuariosSuplentes', 's', 'WITH', 's.idusuario=u.idusuario')
                        ->leftJoin('o.idusuarioComprador', 'u2', 'WITH', 's.idsuplente = u2.idusuario')
                        ->leftJoin('LanClSiteBundle:OrdenesCompraLineas', 'ocl', 'WITH', 'ocl.idoc = o.idoc')
                        ->where('o.activo = true')
                        ->addOrderBy('o.nroOrden', 'ASC');

                /*
                 * En la base de datos Numero de orden es CITEXT entonces
                 * si yo filtro >= 1 y <= 12 la orden 2 no aparece
                 * hay que convertirlo primero?
                 *
                 * Eh....
                 * http://stackoverflow.com/questions/26856176/doctrine2-symfony2-cast-values-before-bind-to-dql-query
                 */

                if (in_array('COMPRADOR', $_SESSION['roles']) && !in_array('ADMIN_CDP', $_SESSION['roles']) && !in_array('CONSULTAS_COMPRAS', $_SESSION['roles']) && !in_array('ADMIN_COMPRAS', $_SESSION['roles']) && !in_array('FUNCIONAL_COMPRAS', $_SESSION['roles'])
                ) {
                    $filterBuilder->andWhere('o.idusuarioComprador = :idusuario');
                    $filterBuilder->setParameter('idusuario', $_SESSION['idusuario']);
                }

                if ($form->get('nroOrdenRango')->get('left_number')->getData() != "") {
                    $filterBuilder->andWhere('CAST(o.nroOrden as bigint) >= :nroOrdenDesde');
                    $filterBuilder->setParameter('nroOrdenDesde', $form->get('nroOrdenRango')->get('left_number')->getData());
                }

                if ($form->get('nroOrdenRango')->get('right_number')->getData() != "") {
                    $filterBuilder->andWhere(' CAST(o.nroOrden as bigint) <= :nroOrdenHasta');
                    $filterBuilder->setParameter('nroOrdenHasta', $form->get('nroOrdenRango')->get('right_number')->getData());
                }

                if ($form->get('idmoneda')->getData() != "") {
                    $filterBuilder->andWhere(' o.idmoneda = :idmoneda');
                    $filterBuilder->setParameter('idmoneda', $form->get('idmoneda')->getData());
                }
                if ($form->get('fechaOrden')->get('left_date')->getData() != "") {
                    $filterBuilder->andWhere(' o.fechaGeneracion >= :fechaDesde');
                    $filterBuilder->setParameter('fechaDesde', $form->get('fechaOrden')->get('left_date')->getData()->format('Ymd'));
                }
                if ($form->get('fechaOrden')->get('right_date')->getData() != "") {
                    $filterBuilder->andWhere(' o.fechaGeneracion <= :fechaHasta');
                    $filterBuilder->setParameter('fechaHasta', $form->get('fechaOrden')->get('right_date')->getData()->add(new \DateInterval('P1D'))->format('Ymd'));
                }
                if ($form->get('OrdenEstado')->getData() != "") {
                    $arrayEstados = array();
                    foreach ($form->get('OrdenEstado')->getData() as $estados) {
                        $arrayEstados[] = $estados->getIdocEstado();
                    }
                    if (sizeof($arrayEstados) > 0) {
                        $filterBuilder->andWhere(" o.idocEstado IN(:OrdenEstado)");
                        $filterBuilder->setParameter('OrdenEstado', $arrayEstados);
                    }
                }
                if ($form->get('UsuarioComprador')->getData() != "") {
                    $filterBuilder->andWhere(' u.nombre = :UsuarioComprador');
                    $filterBuilder->setParameter('UsuarioComprador', $form->get('UsuarioComprador')->getData());
                }
                if ($form->get('UsuarioSuplente')->getData() != "") {
                    $filterBuilder->andWhere(' u2.nombre = :UsuarioSuplente');
                    $filterBuilder->setParameter('UsuarioSuplente', $form->get('UsuarioSuplente')->getData());
                }
                if ($form->get('Proveedor')->getData() != "") {
                    $filterBuilder->andWhere(' p.razonsocial = :Proveedor');
                    $filterBuilder->setParameter('Proveedor', $form->get('Proveedor')->getData());
                }
                if ($form->get('nroBp')->getData() != "") {
                    $filterBuilder->leftJoin('LanClSiteBundle:ProveedoresNumerosBp', 'pnbp', 'WITH', 'pnbp.idproveedor=p.idproveedor');
                    $filterBuilder->andWhere(' pnbp.nrobp = :nroBp');
                    $filterBuilder->setParameter('nroBp', $form->get('nroBp')->getData());
                }
            }
        }

        switch ($_format) {
            case "xls":
                $filterBuilder->select('o.idoc,o.nroOrden,m.codigo,p.razonsocial proveedor,u.nombre comprador,'
                        . 'u2.nombre suplente,e.descripcion estado,o.fechaGeneracion,m.codigo moneda , SUM(ocl.precioTotal) monto');
                $filterBuilder->addGroupBy('o.idoc,o.nroOrden,m.codigo,p.razonsocial,u.nombre,u2.nombre,e.descripcion,o.fechaGeneracion,m.codigo');
                $filterBuilder->addOrderBy('o.idoc');
                $registros = $filterBuilder->getQuery()->getArrayResult();

                $resultadoExportar = array();
                $parametros['title'] = "Busqueda LAN";
                $parametros['subject'] = "Busqueda LAN";
                $parametros['filename'] = "Ordenes de Compra";
                $resultadoExportar[0]['registros'] = $registros;
                $resultadoExportar[0]['title'] = "Busqueda LAN";
                $resultadoExportar[0]['columnas'] = array(
                    array(
                        'campo' => 'nroOrden',
                        'nombreColumna' => 'Orden de Compra',
                        'tipo' => 'texto',
                        'letra' => 'A',
                    ),
                    array(
                        'campo' => 'fechaGeneracion',
                        'nombreColumna' => 'Fecha de Generación',
                        'tipo' => 'fecha',
                        'letra' => 'B',
                    ),
                    array(
                        'campo' => 'monto',
                        'nombreColumna' => 'Precio Neto Total',
                        'letra' => 'C',
                    ),
                    array(
                        'campo' => 'moneda',
                        'nombreColumna' => 'Moneda',
                        'letra' => 'D',
                    ),
                    array(
                        'campo' => 'proveedor',
                        'nombreColumna' => 'Proveedor',
                        'letra' => 'E',
                    ),
                    array(
                        'campo' => 'comprador',
                        'nombreColumna' => 'Comprador',
                        'letra' => 'F',
                    ),
                    array(
                        'campo' => 'suplente',
                        'nombreColumna' => 'Suplente',
                        'letra' => 'G',
                    ),
                    array(
                        'campo' => 'estado',
                        'nombreColumna' => 'Estado',
                        'letra' => 'H',
                    ),
                );

                $ids = array();
                $i = 0;
                foreach ($registros as $registro) {
                    $ids[$i] = $registro['idoc'];
                    $i++;
                }


                $filterBuilder2 = $this->getDoctrine()->getManager()->getRepository("LanClSiteBundle:OrdenesCompraLineas")
                        ->createQueryBuilder('ocl')
                        ->select('oc.idoc,ocl.nroLinea,ocl.cantidadOriginal,ocl.descMaterial,ocl.precioUnitario,e.descripcion,m.codigo moneda,'
                                . 'ocl.fechaEntregaEstimada,ocl.fechaEntregaInformada,ocl.fechaEntregaFinal,'
                                . 'ocl.fechaInformada, ocl.fechaFinal, ocl.cantidadInformada,oc.fechaGeneracion,p.razonsocial,u.nombre comprador,u2.nombre suplente')
                        ->leftJoin('ocl.idoc', 'oc')
                        ->leftJoin('oc.idmoneda', 'm')
                        ->leftJoin('oc.idproveedor', 'p')
                        ->leftJoin('oc.idusuarioComprador', 'u')
                        ->leftJoin('LanClSiteBundle:UsuariosSuplentes', 's', 'WITH', 's.idusuario=u.idusuario')
                        ->leftJoin('oc.idusuarioComprador', 'u2', 'WITH', 's.idsuplente = u2.idusuario')
                        ->leftJoin('ocl.idocLineaEstado', 'e')
                        ->where('oc.idoc IN (:idoc) and ocl.activo=true and oc.activo=true')
                        ->addOrderBy('ocl.idoc')
                        ->addOrderBy('ocl.nroLinea');

                $filterBuilder2->setParameter('idoc', $ids);

                
                
                $lineas = $filterBuilder2->getQuery()->getResult();

                $resultadoExportar2 = array();
                $resultadoExportar2[0]['registros'] = $lineas;
                $resultadoExportar2[0]['title'] = "Busqueda LAN";
                $resultadoExportar2[0]['columnas'] = array(
                    array(
                        'campo' => 'idoc',
                        'nombreColumna' => 'Orden de Compra',
                        'tipo' => 'texto',
                        'letra' => 'A',
                    ),
                    array(
                        'campo' => 'nroLinea',
                        'nombreColumna' => 'Nro Linea',
                        'letra' => 'B',
                    ),
                    array(
                        'campo' => 'fechaGeneracion',
                        'nombreColumna' => 'Fecha Generacion',
                        'tipo' => 'fecha',
                        'letra' => 'C',
                    ),
                    array(
                        'campo' => 'cantidadOriginal',
                        'nombreColumna' => 'Cantidad',
                        'letra' => 'D',
                    ),
                    array(
                        'campo' => 'descMaterial',
                        'nombreColumna' => 'Material',
                        'letra' => 'E',
                    ),
                    array(
                        'campo' => 'precioUnitario',
                        'nombreColumna' => 'Precio Unitario',
                        'letra' => 'F',
                    ),
                    array(
                        'campo' => 'moneda',
                        'nombreColumna' => 'Moneda',
                        'letra' => 'G',
                    ),
                    array(
                        'campo' => 'razonsocial',
                        'nombreColumna' => 'Proveedor',
                        'letra' => 'H',
                    ),
                    array(
                        'campo' => 'fechaEntregaEstimada',
                        'nombreColumna' => 'Fecha de Entrega segun OC',
                        'tipo' => 'fecha',
                        'letra' => 'I',
                    ),
                    array(
                        'campo' => 'fechaEntregaInformada',
                        'nombreColumna' => 'Fecha de Entrega Comprometida',
                        'tipo' => 'fecha',
                        'letra' => 'J',
                    ),
                    array(
                        'campo' => 'fechaInformada',
                        'nombreColumna' => 'Fecha Acknowledgment',
                        'tipo' => 'fecha',
                        'letra' => 'K',
                    ),
                    array(
                        'campo' => 'cantidadInformada',
                        'nombreColumna' => 'Nueva Cantidad',
                        'letra' => 'L',
                    ),
                    array(
                        'campo' => 'fechaEntregaFinal',
                        'nombreColumna' => 'Fecha de Entrega Real (POD)',
                        'tipo' => 'fecha',
                        'letra' => 'M',
                    ),
                    array(
                        'campo' => 'fechaFinal',
                        'nombreColumna' => 'Fecha de Ingreso POD',
                        'tipo' => 'fecha',
                        'letra' => 'N',
                    ),
                    array(
                        'campo' => 'comprador',
                        'nombreColumna' => 'Comprador',
                        'letra' => 'O',
                    ),
                    array(
                        'campo' => 'comprador',
                        'nombreColumna' => 'Suplente',
                        'letra' => 'P',
                    ),
                    array(
                        'campo' => 'descripcion',
                        'nombreColumna' => 'Estado',
                        'letra' => 'Q',
                    ),
                );

                return $this->get('exportar_excel')->exportarExcelLineas($parametros, $resultadoExportar, $resultadoExportar2);
                break;

            case "html":
                if (isset($filterBuilder)) {
                    $filterBuilder->select('o.idoc,o.nroOrden,m.codigo,p.razonsocial proveedor,u.nombre comprador,'
                            . 'u2.nombre suplente,e.descripcion estado,o.fechaGeneracion,m.codigo moneda,SUM(ocl.precioTotal) monto');
                    $filterBuilder->addGroupBy('o.idoc,o.nroOrden,m.codigo,p.razonsocial,u.nombre,u2.nombre,e.descripcion,o.fechaGeneracion,m.codigo');
                    $registros = $filterBuilder->getQuery()->getArrayResult();
                }

                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                        $registros, $this->getRequest()->query->get('page', 1), 10
                );

                $pagination->setPageRange(6);

                return $this->render(
                                'LanClSiteBundle:OrdenesCompra:search.html.twig', array(
                            'pagination' => $pagination,
                            'form' => $form->createView(),
                            'arrayPermisos' => $arrayPermisos
                                )
                );
                break;
        }
    }
    
    
    public function settingsAction(Request $request) {
        $pregunta = new Pregunta();
        $form = $this->createForm(new PreguntaType(), $pregunta);

        $form->handleRequest($request);
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        return $this->render('AoshidowebBundle:Games:settings.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function quizAction(Request $request) {

        $pregunta = new Pregunta();
        $form = $this->createForm(new PreguntaType(), $pregunta);

        $form->handleRequest($request);

        $preguntas = new ArrayCollection();
        if ($form->isValid()) {
            foreach ($pregunta->getTemas() as $tema) {
                $preguntas_temp = $tema->getPreguntas();
                foreach ($preguntas_temp as $pregunta_temp) {
                    if ($pregunta_temp != $pregunta && !$preguntas->contains($pregunta_temp)) {
                        $preguntas->add($pregunta_temp);
                    }
                }
            }
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 4);
        $pagination->setPageRange(6);

        $cantidad = count($preguntas);
        
        switch ($request->getPathInfo()) {
            case '/games/quiz':
                return $this->render('AoshidowebBundle:Games:quiz.html.twig', array(
                            'paginas' => $pagination,
                            'cantidad' => $cantidad,
                ));
            case '/games/cards':
                return $this->render('AoshidowebBundle:Games:cards.html.twig', array(
                            'paginas' => $pagination,
                            'cantidad' => $cantidad,
                ));
        }
        return $this->redirect($this->generateUrl('abms_preguntas'));
    }

}
