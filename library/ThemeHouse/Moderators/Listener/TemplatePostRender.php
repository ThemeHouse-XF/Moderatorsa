<?php

class ThemeHouse_Moderators_Listener_TemplatePostRender extends ThemeHouse_Listener_TemplatePostRender
{
    protected function _getTemplates()
    {
        return array(
            'moderator_list',
        );
    } /* END _getTemplates */

    public static function templatePostRender($templateName, &$content, array &$containerData, XenForo_Template_Abstract $template)
    {
        $templatePostRender = new ThemeHouse_Moderators_Listener_TemplatePostRender($templateName, $content, $containerData, $template);
        list($content, $containerData) = $templatePostRender->run();
    } /* END templatePostRender */

    protected function _moderatorList()
    {
        $viewParams = $this->_fetchViewParams();
        $this->_appendTemplate('th_topctrl_moderators', $viewParams, $this->_containerData['topctrl']);
    } /* END _moderatorList */
}