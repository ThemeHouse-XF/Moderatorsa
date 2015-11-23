<?php

/**
 *
 * @see XenForo_ControllerAdmin_Moderator
 */
class ThemeHouse_Moderators_Extend_XenForo_ControllerAdmin_Moderator extends XFCP_ThemeHouse_Moderators_Extend_XenForo_ControllerAdmin_Moderator
{

    public function actionExport()
    {
        $this->_routeMatch->setResponseType('xml');

        /* @var $moderatorModel XenForo_Model_Moderator */
        $moderatorModel = $this->_getModeratorModel();

        $moderators = array(
            'general_moderators' => $moderatorModel->getAllGeneralModerators(),
            'content_moderators' => $moderatorModel->getContentModerators()
        );

        $viewParams = array(
            'xml' => $moderatorModel->getModeratorsXml($moderators)
        );

        return $this->responseView('ThemeHouse_Moderators_ViewAdmin_Moderator_Export', '', $viewParams);
    } /* END actionExport */

    public function actionImport()
    {
        $moderatorModel = $this->_getModeratorModel();

        if ($this->isConfirmedPost()) {
            $input = $this->_input->filter(
                array(
                    'overwrite' => XenForo_Input::UINT
                ));

            $upload = XenForo_Upload::getUploadedFile('upload');
            if (!$upload) {
                return $this->responseError(
                    new XenForo_Phrase('th_please_upload_valid_moderator_xml_file_moderators'));
            }

            $document = $this->getHelper('Xml')->getXmlFromFile($upload);
            $caches = $moderatorModel->importModeratorsXml($document, $input['overwrite']);

            return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS,
                XenForo_Link::buildAdminLink('moderators'));
        } else {
            return $this->responseView('ThemeHouse_Moderators_ViewAdmin_Moderator_Import',
                'th_moderator_import_moderators');
        }
    } /* END actionImport */
}