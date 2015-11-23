<?php

/**
 * Exports moderators as XML.
 */
class ThemeHouse_Moderators_ViewAdmin_Moderator_Export extends XenForo_ViewAdmin_Base
{

    public function renderXml()
    {
        $this->setDownloadFileName('moderators.xml');
        return $this->_params['xml']->saveXml();
    } /* END renderXml */ /* renderXml */
}