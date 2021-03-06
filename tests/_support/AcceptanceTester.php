<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor {

    use _generated\AcceptanceTesterActions;

    public function fillCkEditorById($element_id, $content) {
        $this->fillRteEditor(
                \Facebook\WebDriver\WebDriverBy::cssSelector(
                        '#cke_' . $element_id . ' .cke_wysiwyg_frame'
                ), $content
        );
    }

    public function fillCkEditorByName($element_name, $content) {
        $this->fillRteEditor(
                \Facebook\WebDriver\WebDriverBy::cssSelector(
                        'textarea[name="' . $element_name . '"] + .cke .cke_wysiwyg_frame'
                ), $content
        );
    }

    public function fillTinyMceEditorById($id, $content) {
        $this->fillTinyMceEditor('id', $id, $content);
    }

    public function fillTinyMceEditorByName($name, $content) {
        $this->fillTinyMceEditor('name', $name, $content);
    }

    private function fillTinyMceEditor($attribute, $value, $content) {
        $this->fillRteEditor(
                \Facebook\WebDriver\WebDriverBy::xpath(
                        '//textarea[@' . $attribute . '=\'' . $value . '\']/../div[contains(@class, \'mce-tinymce\')]//iframe'
                ), $content
        );
    }

    private function fillRteEditor($selector, $content) {
        $this->executeInSelenium(
                function (\Facebook\WebDriver\Remote\RemoteWebDriver $webDriver)
                use ($selector, $content) {
            $webDriver->switchTo()->frame(
                    $webDriver->findElement($selector)
            );

            $webDriver->executeScript(
                    'arguments[0].innerHTML = "' . addslashes($content) . '"', [$webDriver->findElement(\Facebook\WebDriver\WebDriverBy::tagName('body'))]
            );

            $webDriver->switchTo()->defaultContent();
        });
    }

    public function login($name, $password) {
        $I = $this;
        $I->amOnPage('/');
        $I->fillField('_username', $name);
        $I->fillField('_password', $password);
        $I->click('_submit');
        $I->see('Aoshido');
    }

}
