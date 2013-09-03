<?php

namespace console\ext;

class ConsoleTemplater extends \CBehavior
{

    private $_theme;
    private $_viewPath;

    /**
     * Returns the widget factory.
     * @return IWidgetFactory the widget factory
     * @since 1.1
     */
    public function getWidgetFactory() {
        return $this->owner->getComponent('widgetFactory');
    }

    /**
     * @return CThemeManager the theme manager.
     */
    public function getThemeManager() {
        return $this->owner->getComponent('themeManager');
    }

    /**
     * @return CTheme the theme used currently. Null if no theme is being used.
     */
    public function getTheme() {
        if (is_string($this->_theme)) {
            $this->_theme = $this->getThemeManager()->getTheme($this->_theme);
        }
        return $this->_theme;
    }

    /**
     * @param string $value the theme name
     */
    public function setTheme($value) {
        $this->_theme = $value;
    }

    /**
     * Returns the view renderer.
     * If this component is registered and enabled, the default
     * view rendering logic defined in {@link CBaseController} will
     * be replaced by this renderer.
     * @return IViewRenderer the view renderer.
     */
    public function getViewRenderer() {
        return $this->owner->getComponent('viewRenderer');
    }

    /**
     * @return string the root directory of view files. Defaults to 'protected/views'.
     */
    public function getViewPath() {
        if ($this->_viewPath !== null)
            return $this->_viewPath;
        else
            return $this->_viewPath = $this->owner->getBasePath() . DIRECTORY_SEPARATOR . 'views';
    }
}
