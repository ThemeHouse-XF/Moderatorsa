<?php

/**
 *
 * @see XenForo_Model_Moderator
 */
class ThemeHouse_Moderators_Extend_XenForo_Model_Moderator extends XFCP_ThemeHouse_Moderators_Extend_XenForo_Model_Moderator
{
    /**
     * Gets the XML representation of all moderators.
     *
     * @param array $moderators
     *
     * @return DOMDocument
     */
    public function getModeratorsXml(array $moderators)
    {
        $document = new DOMDocument('1.0', 'utf-8');
        $document->formatOutput = true;

        $rootNode = $document->createElement('moderators');

        $generalModeratorsNode = $document->createElement('general_moderators');
        foreach ($moderators['general_moderators'] as $generalModerator) {
            $generalModeratorNode = $document->createElement('general_moderator');
            $this->_appendGeneralModeratorXml($generalModeratorNode, $generalModerator);
            $generalModeratorsNode->appendChild($generalModeratorNode);
        }
        $rootNode->appendChild($generalModeratorsNode);

        $contentModeratorsNode = $document->createElement('content_moderators');
        foreach ($moderators['content_moderators'] as $contentModerator) {
            $contentModeratorNode = $document->createElement('content_moderator');
            $this->_appendContentModeratorXml($contentModeratorNode, $contentModerator);
            $contentModeratorsNode->appendChild($contentModeratorNode);
        }
        $rootNode->appendChild($contentModeratorsNode);

        $document->appendChild($rootNode);

        return $document;
    } /* END getModeratorsXml */

    /**
     * @param DOMElement $rootNode
     * @param array $moderator
     */
    protected function _appendGeneralModeratorXml(DOMElement $rootNode, $moderator)
    {
        $document = $rootNode->ownerDocument;

        $rootNode->setAttribute('extra_user_group_ids', $moderator['extra_user_group_ids']);
        $rootNode->setAttribute('is_super_moderator', $moderator['is_super_moderator']);
        $rootNode->setAttribute('username', $moderator['username']);
        $rootNode->setAttribute('user_id', $moderator['user_id']);

        $permissionsNode = $document->createElement('moderator_permissions');
        $rootNode->appendChild($permissionsNode);
        $permissionsNode->appendChild(XenForo_Helper_DevelopmentXml::createDomCdataSection($document, $moderator['moderator_permissions']));
    } /* END _appendGeneralModeratorXml */

    /**
     * @param DOMElement $rootNode
     * @param array $moderator
     */
    protected function _appendContentModeratorXml(DOMElement $rootNode, $moderator)
    {
        $document = $rootNode->ownerDocument;

        $rootNode->setAttribute('content_id', $moderator['content_id']);
        $rootNode->setAttribute('content_type', $moderator['content_type']);
        $rootNode->setAttribute('username', $moderator['username']);
        $rootNode->setAttribute('user_id', $moderator['user_id']);

        $permissionsNode = $document->createElement('moderator_permissions');
        $rootNode->appendChild($permissionsNode);
        $permissionsNode->appendChild(XenForo_Helper_DevelopmentXml::createDomCdataSection($document, $moderator['moderator_permissions']));
    } /* END _appendContentModeratorXml */

    /**
     * Imports a moderators XML file.
     *
     * @param SimpleXMLElement $document
     * @param integer $overwrite
     *
     * @return array List of cache rebuilders to run
     */
    public function importModeratorsXml(SimpleXMLElement $document, $overwrite = 0)
    {
        if ($document->getName() != 'moderators') {
            throw new XenForo_Exception(new XenForo_Phrase('th_provided_file_is_not_valid_moderator_xml_moderators'), true);
        }

        $db = $this->_getDb();
        /* @var $generalModerator SimpleXMLElement */
        XenForo_Db::beginTransaction($db);

        $generalModerators = XenForo_Helper_DevelopmentXml::fixPhpBug50670($document->general_moderators->general_moderator);
        foreach ($generalModerators as $generalModerator) {
            $modPerms = XenForo_Helper_DevelopmentXml::processSimpleXmlCdata($generalModerator->moderator_permissions);
            if ($modPerms) {
                $modPerms = unserialize($modPerms);
            } else {
                $modPerms = array();
            }
            $userId = (int)$generalModerator['user_id'];
            $existing = $this->getGeneralModeratorByUserId($userId);
            if (!$overwrite && $existing) {
                continue;
            }
            $isSuperModerator = (int)$generalModerator['is_super_moderator'];
            $extra = array(
                'extra_user_group_ids' => $generalModerator['extra_user_group_ids'],
            );
            $this->insertOrUpdateGeneralModerator($userId, $modPerms, $isSuperModerator, $extra);
        }

        $contentModerators = XenForo_Helper_DevelopmentXml::fixPhpBug50670($document->content_moderators->content_moderator);
        foreach ($contentModerators as $contentModerator) {
            $modPerms = XenForo_Helper_DevelopmentXml::processSimpleXmlCdata($contentModerator->moderator_permissions);
            if ($modPerms) {
                $modPerms = unserialize($modPerms);
            } else {
                $modPerms = array();
            }
            $contentType = (string)$contentModerator['content_type'];
            $contentId = (int)$contentModerator['content_id'];
            $userId = (int)$contentModerator['user_id'];
            $existing = $this->getContentModeratorByContentAndUserId($contentType, $contentId, $userId);
            if (!$overwrite && $existing) {
                continue;
            }
            $this->insertOrUpdateContentModerator($userId, $contentType, $contentId, $modPerms);
        }
        XenForo_Db::commit($db);
    } /* END importModeratorsXml */
}