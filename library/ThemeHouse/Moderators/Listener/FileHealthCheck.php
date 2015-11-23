<?php

class ThemeHouse_Moderators_Listener_FileHealthCheck
{

    public static function fileHealthCheck(XenForo_ControllerAdmin_Abstract $controller, array &$hashes)
    {
        $hashes = array_merge($hashes,
            array(
                'library/ThemeHouse/Moderators/Extend/XenForo/ControllerAdmin/Moderator.php' => '20b1bc566332fe8b3b64cb382d9b8bb9',
                'library/ThemeHouse/Moderators/Extend/XenForo/Model/Moderator.php' => '6d0108504391ed2c852e5d5c6abccde3',
                'library/ThemeHouse/Moderators/Install/Controller.php' => '34de22205aa44ffbdffbdfed492a4dad',
                'library/ThemeHouse/Moderators/Listener/LoadClass.php' => '14a7639fadf36c62015843ff1f77023d',
                'library/ThemeHouse/Moderators/Listener/TemplatePostRender.php' => '9ebf19cc8f2e12537a060d90fd39eca2',
                'library/ThemeHouse/Moderators/ViewAdmin/Moderator/Export.php' => 'bc743c590909ee8b78690dec6429bf72',
                'library/ThemeHouse/Install.php' => '18f1441e00e3742460174ab197bec0b7',
                'library/ThemeHouse/Install/20151109.php' => '2e3f16d685652ea2fa82ba11b69204f4',
                'library/ThemeHouse/Deferred.php' => 'ebab3e432fe2f42520de0e36f7f45d88',
                'library/ThemeHouse/Deferred/20150106.php' => 'a311d9aa6f9a0412eeba878417ba7ede',
                'library/ThemeHouse/Listener/ControllerPreDispatch.php' => 'fdebb2d5347398d3974a6f27eb11a3cd',
                'library/ThemeHouse/Listener/ControllerPreDispatch/20150911.php' => 'f2aadc0bd188ad127e363f417b4d23a9',
                'library/ThemeHouse/Listener/InitDependencies.php' => '8f59aaa8ffe56231c4aa47cf2c65f2b0',
                'library/ThemeHouse/Listener/InitDependencies/20150212.php' => 'f04c9dc8fa289895c06c1bcba5d27293',
                'library/ThemeHouse/Listener/LoadClass.php' => '5cad77e1862641ddc2dd693b1aa68a50',
                'library/ThemeHouse/Listener/LoadClass/20150518.php' => 'f4d0d30ba5e5dc51cda07141c39939e3',
                'library/ThemeHouse/Listener/Template.php' => '0aa5e8aabb255d39cf01d671f9df0091',
                'library/ThemeHouse/Listener/Template/20150106.php' => '8d42b3b2d856af9e33b69a2ce1034442',
                'library/ThemeHouse/Listener/TemplatePostRender.php' => 'b6da98a55074e4cde833abf576bc7b5d',
                'library/ThemeHouse/Listener/TemplatePostRender/20150106.php' => 'efccbb2b2340656d1776af01c25d9382',
            ));
    }
}