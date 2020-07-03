<?php
if (!empty($view->kr)) {
    //For teh saved country
    if(isset($_COOKIE['sq_country'])) {
        $view->country = $_COOKIE['sq_country'];
    }

    foreach ($view->kr as $nr => $row) {
        if (!isset($row->keyword)) continue;

        $in_briefcase = false;
        if (!empty($view->keywords))
            foreach ($view->keywords as $krow) {
                if (trim(strtolower($krow->keyword)) == trim(strtolower($row->keyword))) {
                    $in_briefcase = true;
                    break;
                }
            } ?>
        <tr class="<?php echo($in_briefcase ? 'bg-briefcase' : '') ?>">
            <td style="width: 33%;"><?php echo(isset($row->keyword) ? $row->keyword : '') ?></td>
            <td style="width: 1%;"><?php echo(isset($view->country) ? $view->country : 'com') ?></td>
            <td style="width: 20%; color: <?php echo $row->stats->sc->color ?>"><?php echo(isset($row->stats->sc->text) ? '<span data-value="' . $row->stats->sc->value . '">' . $row->stats->sc->text . '</span>' : '') ?></td>
            <td style="width: 13%; color: <?php echo $row->stats->sv->color ?>"><?php echo(isset($row->stats->sv) ? '<span data-value="' . $row->stats->sv->value . '">' . (is_numeric($row->stats->sv->absolute) ? number_format($row->stats->sv->absolute, 0, '', '.') . '</span>' : $row->stats->sv->absolute) : '') ?></td>
            <td style="width: 15%; color: <?php echo $row->stats->tw->color ?>"><?php echo(isset($row->stats->tw) ? '<span data-value="' . $row->stats->tw->value . '">' . $row->stats->tw->text . '</span>' : '') ?></td>
            <td style="width: 12%; color: <?php echo $row->stats->td->color ?>">
                <?php if (isset($row->stats->td)) { ?>
                    <div style="width: 60px; height: 30px;">
                        <canvas class="sq_trend" data-values=" <?php echo join(',', $row->stats->td->absolute) ?>"></canvas>
                    </div>
                <?php } ?>
            </td>
            <td class="px-0" style="width: 24px;">
                <div class="sq_sm_menu">
                    <div class="sm_icon_button sm_icon_options">
                        <i class="fa fa-ellipsis-v"></i>
                    </div>
                    <div class="sq_sm_dropdown">
                        <ul class="p-2 m-0 text-left">
                            <?php
                            $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('/post-new.php?keyword=' . urlencode($row->keyword));
                            if ($view->post_id) {
                                $edit_link = SQ_Classes_Helpers_Tools::getAdminUrl('post.php?post=' . (int)$view->post_id . '&action=edit&keyword=' . urlencode($row->keyword));
                            }
                            ?>
                            <li class="sq_research_selectit border-bottom m-0 p-1 py-2" data-post="<?php echo $edit_link ?>" data-keyword="<?php echo htmlspecialchars(addslashes($row->keyword)) ?>">
                                <i class="sq_icons_small sq_sla_icon"></i>
                                <?php echo __('Optimize for this', _SQ_PLUGIN_NAME_) ?>
                            </li>
                            <?php if ($in_briefcase) { ?>
                                <li class="bg-briefcase m-0 p-1 py-2 text-black-50">
                                    <i class="sq_icons_small sq_briefcase_icon"></i>
                                    <?php _e('Already in briefcase', _SQ_PLUGIN_NAME_); ?>
                                </li>
                            <?php } else { ?>
                                <li class="sq_research_add_briefcase m-0 p-1 py-2" data-keyword="<?php echo htmlspecialchars(str_replace('"', '\"', $row->keyword)) ?>">
                                    <i class="sq_icons_small sq_briefcase_icon"></i>
                                    <?php _e('Add to briefcase', _SQ_PLUGIN_NAME_); ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    <?php }
} ?>