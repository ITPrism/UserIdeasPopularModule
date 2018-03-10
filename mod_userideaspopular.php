<?php
/**
 * @package      Userideas
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2016 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('Prism.init');
jimport('Userideas.init');

JHtml::_('Prism.ui.styles');

$moduleclassSfx = htmlspecialchars($params->get('moduleclass_sfx'));

$limitResults = $params->get('items_limit', 5);
if ($limitResults <= 0) {
    $limitResults = 5;
}

$resultOptions = array(
    'limit' => $limitResults,
    'access_groups' => \JFactory::getUser()->getAuthorisedViewLevels(),
    'state' => Prism\Constants::PUBLISHED
);

$items   =  new Userideas\Statistic\Items\Popular(JFactory::getDbo());
$items->load($resultOptions);

// Get component parameters
$componentParams = JComponentHelper::getParams('com_userideas');
/** @var  $componentParams Joomla\Registry\Registry */

// Get options
$displayPublisher   = (int)$params->get('show_author', $componentParams->get('show_author'));
$displayDate        = (int)$params->get('show_create_date', $componentParams->get('show_create_date'));
$displayDescription = (int)$params->get('show_intro', $componentParams->get('show_intro'));
$displayVotes       = (int)$params->get('show_votes', $componentParams->get('show_votes'));
$displayHits        = (int)$params->get('show_hits', $componentParams->get('show_hits'));
$titleLength        = (int)$params->get('title_length', $componentParams->get('title_length'));
$descriptionLength  = (int)$params->get('intro_length', $componentParams->get('intro_length'));

// Display user social profile ( integrate ).
if ($displayPublisher === 1) {
    $socialProfiles = null;

    if ($componentParams->get('integration_social_platform')) {
        $usersIds = $items->getValues('user_id');
        $usersIds = Joomla\Utilities\ArrayHelper::toInteger($usersIds);
        $usersIds = array_filter(array_unique($usersIds));

        $options = new \Joomla\Registry\Registry(array(
            'platform' => $componentParams->get('integration_social_platform'),
            'user_ids' => $usersIds
        ));

        $socialProfilesBuilder = new Prism\Integration\Profiles\Factory($options);
        $socialProfiles        = $socialProfilesBuilder->create();
    }
}

require JModuleHelper::getLayoutPath('mod_userideaspopular', $params->get('layout', 'default'));
