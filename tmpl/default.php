<?php
/**
 * @package      Userideas
 * @subpackage   Modules
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2015 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      GNU General Public License version 3 or later; see LICENSE.txt
 */
 
// no direct access
defined('_JEXEC') or die; ?>
<div class="ui-modlatest<?php echo $moduleclassSfx; ?>">
<?php
foreach ($items as $item) {
    $description  = Prism\Utilities\StringHelper::clean($item->description);
    $title        = Prism\Utilities\StringHelper::clean($item->title);

    $title        = JHtmlString::truncate($title, $titleLength);
    $description  = JHtmlString::truncate($description, $descriptionLength);

    // Route project link
    $itemLink     = JRoute::_(UserideasHelperRoute::getDetailsRoute($item->slug, $item->catslug));
?>
     <div class="row">
        <div class="col-md-12">
           <h5><a href="<?php echo $itemLink;?>"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></a></h5>

           <?php if ($displayDescription === 1){ ?>
           <p><?php echo $description;?></p>
           <?php }?>

            <?php if ($displayPublisher or $displayDate or $displayVotes or $displayHits) {?>
                <div class="well well-sm clearfix">
                    <div class="font-xsmall">
                        <?php
                        if ($displayPublisher === 1 and $displayDate === 0) {
                            $profile = JHtml::_('userideas.profile', $socialProfiles, $item->user_id);
                            echo JHtml::_('userideas.publishedBy', $item->author, $profile);
                        } elseif ($displayDate === 1 and $displayPublisher === 0) {
                            echo JHtml::_('userideas.publishedOn', $item->record_date);
                        } elseif ($displayDate === 1 and $displayPublisher === 1) {
                            $profile = JHtml::_('userideas.profile', $socialProfiles, $item->user_id);
                            echo JHtml::_('userideas.publishedByOn', $item->author, $item->record_date, $profile);
                        }
                        ?>
                    </div>
                    <div>
                        <?php
                        if ($displayVotes) {
                            echo JHtml::_('userideas.votes', (int)$item->votes);
                        } ?>
                        <?php
                        if ($displayHits) {
                            echo JHtml::_('userideas.hits', (int)$item->hits);
                        } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
</div>