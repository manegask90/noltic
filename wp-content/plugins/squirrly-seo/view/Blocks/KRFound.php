<div id="sq_krfound" class="mt-5">
    <div class="col-sm-12 my-4">
        <div class="col-sm-12 row my-4">
            <div class="row text-left m-0 p-0">
                <div class="sq_icons sq_krfound_icon m-2"></div>
                <h3 class="card-title"><?php _e('Suggested Keywords', _SQ_PLUGIN_NAME_); ?>:</h3>
            </div>
        </div>
    </div>
    <?php if (isset($view->keywords) && !empty($view->keywords)) { ?>
        <div class="card my-0 py-4 px-2 bg-light col-sm-12">
            <table class="sq_krfound_list table table-striped table-hover my-2" cellpadding="0" cellspacing="0" border="0">
                <thead>
                <tr>
                    <th style="width: 30%;"><?php echo __('Keyword', _SQ_PLUGIN_NAME_) ?></th>
                    <th scope="col" title="<?php _e('Country', _SQ_PLUGIN_NAME_) ?>"><?php _e('Co', _SQ_PLUGIN_NAME_) ?></th>
                    <th style="width: 150px;">
                        <i class="fa fa-users" title="<?php echo __('Competition', _SQ_PLUGIN_NAME_) ?>"></i>
                        <?php echo __('Competition', _SQ_PLUGIN_NAME_) ?>
                    </th>
                    <th style="width: 80px;">
                        <i class="fa fa-search" title="<?php echo __('SEO Search Volume', _SQ_PLUGIN_NAME_) ?>"></i>
                        <?php echo __('SV', _SQ_PLUGIN_NAME_) ?>
                    </th>
                    <th style="width: 135px;">
                        <i class="fa fa-comments-o" title="<?php echo __('Recent discussions', _SQ_PLUGIN_NAME_) ?>"></i>
                        <?php echo __('Discussion', _SQ_PLUGIN_NAME_) ?>
                    </th>
                    <th style="width: 120px;">
                        <i class="fa fa-bar-chart" title="<?php echo __('Trending', _SQ_PLUGIN_NAME_) ?>"></i>
                        <?php echo __('Trending', _SQ_PLUGIN_NAME_) ?>
                    </th>
                    <th style="width: 8%;"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($view->keywords))
                    foreach ($view->keywords as $key => $row) {
                        $research = '';
                        $keyword_labels = array();

                        if(!isset($row->id)){
                            continue;
                        }

                        if (isset($row->data) && $row->data <> '') {
                            $research = json_decode($row->data);

                            if (isset($research->sv->absolute) && is_numeric($research->sv->absolute)) {
                                $research->sv->absolute = number_format((int)$research->sv->absolute, 0, '', '.');
                            }
                        }
                        ?>
                        <tr id="sq_row_<?php echo $row->id ?>">
                            <td style="width: 280px;">
                                <span style="display: block; clear: left; float: left;"><?php echo $row->keyword ?></span>
                            </td>
                            <td>
                                <span style="display: block; clear: left; float: left;"><?php echo $row->country ?></span>
                            </td>
                            <td style="width: 150px;">
                                <?php if (isset($research->sc)) { ?>
                                    <span style="color: <?php echo $research->sc->color ?>" title="<?php echo __('Competition', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->sc->text <> '' ? $research->sc->text : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                <?php } ?>
                            </td>
                            <td style="width: 80px;">
                                <?php if (isset($research->sv)) { ?>
                                    <span style="color: <?php echo $research->sv->color ?>" title="<?php echo __('SEO Search Volume', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->sv->absolute <> '' ? $research->sv->absolute : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                <?php } ?>
                            </td>
                            <td style="width: 130px;">
                                <?php if (isset($research->tw)) { ?>
                                    <span style="color: <?php echo $research->tw->color ?>" title="<?php echo __('Recent discussions', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->tw->text <> '' ? $research->tw->text : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                <?php } ?>
                            </td>
                            <td style="width: 120px;">
                                <?php if (isset($research->td)) { ?>
                                    <span style="color: <?php echo $research->td->color ?>" title="<?php echo __('Trending', _SQ_PLUGIN_NAME_) ?>"><?php echo($research->td->text <> '' ? $research->td->text : __('-', _SQ_PLUGIN_NAME_)) ?></span>
                                <?php } ?>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm sq_research_selectit" data-post="<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_assistant') ?>" data-keyword="<?php echo htmlspecialchars(addslashes($row->keyword)) ?>"><?php echo __('Use Keyword', _SQ_PLUGIN_NAME_) ?></button>
                            </td>
                        </tr>
                        <?php
                    }
                ?>

                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="card mr-2 bg-light col-sm-12">
            <div class="card-body">
                <h5 class="text-center"><?php echo __('Once a week, Squirrly checks all the keywords from your briefcase.'); ?></h5>
                <h5 class="text-center"><?php echo __('If it finds better keywords, they will be listed here'); ?></h5>
                <h6 class="text-center text-black-50 mt-3"><?php echo __('Until then, add keywords in Briefcase'); ?>:</h6>
                <div class="row col-sm-12 my-4 text-center">
                    <div class="my-0 mx-auto justify-content-center text-center">
                        <h6 onclick="location.href ='<?php echo SQ_Classes_Helpers_Tools::getAdminUrl('sq_research', 'briefcase') ?>'" class="text-black-50 text-right">
                            <div style="float: right; cursor: pointer"><?php echo __('Go to Briefcase'); ?></div>
                            <i class="sq_icons_small sq_briefcase_icon" style="float: right; width: 20px; cursor: pointer"></i>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>