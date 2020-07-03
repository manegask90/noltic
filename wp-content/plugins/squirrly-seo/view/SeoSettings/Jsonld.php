<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_settings')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">' . __("You do not have permission to access this page. You need Squirrly SEO Admin role", _SQ_PLUGIN_NAME_) . '</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_seosettings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <?php do_action('sq_form_notices'); ?>
                <form method="POST">
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_seosettings_jsonld', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_seosettings_jsonld"/>

                    <div class="card col-sm-12 p-0">
                        <?php do_action('sq_subscription_notices'); ?>

                        <div class="card-body p-2 bg-title rounded-top  row">
                            <div class="col-sm-8 text-left m-0 p-0">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_jsonld_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php _e('JSON-LD Structured Data', _SQ_PLUGIN_NAME_); ?>:</h3>
                            </div>
                            <div class="col-sm-4 text-right">
                                <div class="checker col-sm-12 row my-2 py-1 mx-0 px-0 ">
                                    <div class="col-sm-12 p-0 sq-switch redgreen sq-switch-sm ">
                                        <div class="sq_help_question float-right">
                                            <a href="https://howto.squirrly.co/kb/json-ld-structured-data/" target="_blank"><i class="fa fa-question-circle m-0 p-0"></i></a>
                                        </div>
                                        <label for="sq_auto_jsonld" class="mr-2"><?php _e('Activate JSON-LD', _SQ_PLUGIN_NAME_); ?></label>
                                        <input type="hidden" name="sq_auto_jsonld" value="0"/>
                                        <input type="checkbox" id="sq_auto_jsonld" name="sq_auto_jsonld" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld') ? 'checked="checked"' : '') ?> value="1"/>
                                        <label for="sq_auto_jsonld" class="mx-2"></label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0 <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_auto_jsonld') ? '' : 'sq_deactivated') ?>">
                            <div class="card-body p-0">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 border-0 ">
                                        <?php
                                        $jsonld = SQ_Classes_Helpers_Tools::getOption('sq_jsonld');
                                        $jsonldtype = SQ_Classes_Helpers_Tools::getOption('sq_jsonld_type');
                                        ?>

                                        <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">
                                            <div class="col-sm-12 row mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <div class="font-weight-bold"><?php _e('Your Site Type', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50 my-1"><?php echo __('The Organization details will be added in JSON-LD publisher section for every page and post', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">

                                                    <select name="sq_jsonld_type" class="form-control bg-input mb-1">
                                                        <option value="Organization" <?php echo(($jsonldtype == 'Organization') ? 'selected="selected"' : ''); ?>><?php _e('Organization', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="Person" <?php echo(($jsonldtype == 'Person') ? 'selected="selected"' : ''); ?>><?php _e('Personal', _SQ_PLUGIN_NAME_); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 py-4 border-bottom tab-panel tab-panel-Organization" style="<?php echo(($jsonldtype == 'Person') ? 'display:none' : ''); ?>">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Your Organization Name', _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#Add-JSON-LD-Company" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php _e('eg. COMPANY LTD', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][name]" value="<?php echo(($jsonld['Organization']['name'] <> '') ? $jsonld['Organization']['name'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Logo URL', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                                    <input id="sq_jsonld_logo_organization" type="text" class="form-control bg-input" name="sq_jsonld[Organization][logo]" value="<?php echo(($jsonld['Organization']['logo'] <> '') ? $jsonld['Organization']['logo'] : '') ?>"/>
                                                    <input type="button" class="sq_imageselect btn btn-primary rounded-right" data-destination="sq_jsonld_logo_organization" value="<?php echo __('Select Image', _SQ_PLUGIN_NAME_) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Contact Phone', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php _e('eg. +1-541-754-3010', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Organization][telephone]" value="<?php echo(($jsonld['Organization']['telephone']) ? $jsonld['Organization']['telephone'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row mx-0 my-3">
                                                <div class="col-sm-4 p-1">
                                                    <div class="font-weight-bold"><?php _e('Contact Type', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50 my-1"></div>
                                                </div>
                                                <div class="col-sm-5 p-0 input-group">
                                                    <select name="sq_jsonld[Organization][contactType]" class="form-control bg-input mb-1">
                                                        <option value="customer service" <?php echo(($jsonld['Organization']['contactType'] == 'customer service') ? 'selected="selected"' : ''); ?>><?php _e('Customer Service', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="technical support" <?php echo(($jsonld['Organization']['contactType'] == 'technical support') ? 'selected="selected"' : ''); ?>><?php _e('Technical Support', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="billing support" <?php echo(($jsonld['Organization']['contactType'] == 'billing support') ? 'selected="selected"' : ''); ?>><?php _e('Billing Support', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="bill payment" <?php echo(($jsonld['Organization']['contactType'] == 'bill payment') ? 'selected="selected"' : ''); ?>><?php _e('Bill Payment', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="sales" <?php echo(($jsonld['Organization']['contactType'] == 'sales') ? 'selected="selected"' : ''); ?>><?php _e('Sales', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="reservations" <?php echo(($jsonld['Organization']['contactType'] == 'reservations') ? 'selected="selected"' : ''); ?>><?php _e('Reservations', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="credit card support" <?php echo(($jsonld['Organization']['contactType'] == 'credit card support') ? 'selected="selected"' : ''); ?>><?php _e('Credit Card Support', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="emergency" <?php echo(($jsonld['Organization']['contactType'] == 'emergency') ? 'selected="selected"' : ''); ?>><?php _e('Emergency', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="baggage tracking" <?php echo(($jsonld['Organization']['contactType'] == 'baggage tracking') ? 'selected="selected"' : ''); ?>><?php _e('Baggage Tracking', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="roadside assistance" <?php echo(($jsonld['Organization']['contactType'] == 'roadside assistance') ? 'selected="selected"' : ''); ?>><?php _e('Roadside Assistance', _SQ_PLUGIN_NAME_); ?></option>
                                                        <option value="package tracking" <?php echo(($jsonld['Organization']['contactType'] == 'package tracking') ? 'selected="selected"' : ''); ?>><?php _e('Package Tracking', _SQ_PLUGIN_NAME_); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Short Description', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php _e('A short description about the company. 20-50 words.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0">
                                                    <textarea class="form-control" name="sq_jsonld[Organization][description]" rows="3"><?php echo(($jsonld['Organization']['description'] <> '') ? $jsonld['Organization']['description'] : '') ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 py-4 border-bottom tab-panel tab-panel-Person" style="<?php echo(($jsonldtype == 'Organization') ? 'display:none' : ''); ?>">
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Your Name', _SQ_PLUGIN_NAME_); ?>:
                                                    <a href="https://howto.squirrly.co/kb/json-ld-structured-data/#Add-JSON-LD-Profile" target="_blank"><i class="fa fa-question-circle m-0 px-2" style="display: inline;"></i></a>
                                                    <div class="small text-black-50 my-1"><?php _e('eg. John Smith', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Person][name]" value="<?php echo(($jsonld['Person']['name'] <> '') ? $jsonld['Person']['name'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Job Title', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php _e('eg. Sales Manager', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Person][jobTitle]" value="<?php echo(($jsonld['Person']['jobTitle'] <> '') ? $jsonld['Person']['jobTitle'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Logo URL', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group input-group-lg">
                                                    <input id="sq_jsonld_logo_person" type="text" class="form-control bg-input" name="sq_jsonld[Person][logo]" value="<?php echo(($jsonld['Person']['logo'] <> '') ? $jsonld['Person']['logo'] : '') ?>"/>
                                                    <input type="button" class="sq_imageselect form-control btn btn-primary rounded-right col-sm-3" data-destination="sq_jsonld_logo_person" value="<?php echo __('Select Image', _SQ_PLUGIN_NAME_) ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Contact Phone', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php _e('eg. +1-541-754-3010', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-5 p-0 input-group input-group-lg">
                                                    <input type="text" class="form-control bg-input" name="sq_jsonld[Person][telephone]" value="<?php echo(($jsonld['Person']['telephone'] <> '') ? $jsonld['Person']['telephone'] : '') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-0 pr-3 font-weight-bold">
                                                    <?php _e('Short Description', _SQ_PLUGIN_NAME_); ?>:
                                                    <div class="small text-black-50 my-1"><?php _e('A short description about your job title.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0">
                                                    <textarea class="form-control" name="sq_jsonld[Person][description]" rows="3"><?php echo(($jsonld['Person']['description'] <> '') ? $jsonld['Person']['description'] : '') ?></textarea>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="bg-title p-2 sq_advanced">
                                        <h3 class="card-title"><?php _e('More Json-LD Settings', _SQ_PLUGIN_NAME_); ?>:</h3>
                                    </div>
                                    <div class="col-sm-12 py-4 border-bottom tab-panel sq_advanced">
                                        <?php if (SQ_Classes_Helpers_Tools::isPluginInstalled('woocommerce/woocommerce.php')) { ?>
                                            <div class="col-sm-12 row mb-1 ml-1 sq_advanced">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_jsonld_woocommerce" value="0"/>
                                                        <input type="checkbox" id="sq_jsonld_woocommerce" name="sq_jsonld_woocommerce" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_woocommerce') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_jsonld_woocommerce" class="ml-2"><?php _e('Add Support For Woocommerce', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Improve the Woocommerce Product and Orders Schema with the required data.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 row mb-1 ml-1">
                                                <div class="checker col-sm-12 row my-2 py-1">
                                                    <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                        <input type="hidden" name="sq_jsonld_product_defaults" value="0"/>
                                                        <input type="checkbox" id="sq_jsonld_product_defaults" name="sq_jsonld_product_defaults" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_product_defaults') ? 'checked="checked"' : '') ?> value="1"/>
                                                        <label for="sq_jsonld_product_defaults" class="ml-2"><?php _e('Add default data for Woocommerce Products', _SQ_PLUGIN_NAME_); ?></label>
                                                        <div class="offset-1 small text-black-50"><?php _e('Add default data for JSON-LD aggregateRating, review, offers, sku, mpn to avoid GSC errors.', _SQ_PLUGIN_NAME_); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="col-sm-12 row mb-1 ml-1 sq_advanced">
                                            <div class="checker col-sm-12 row my-2 py-1">
                                                <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_jsonld_breadcrumbs" value="0"/>
                                                    <input type="checkbox" id="sq_jsonld_breadcrumbs" name="sq_jsonld_breadcrumbs" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_breadcrumbs') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_jsonld_breadcrumbs" class="ml-2"><?php _e('Add Breadcrumbs in Json-LD', _SQ_PLUGIN_NAME_); ?></label>
                                                    <div class="offset-1 small text-black-50"><?php _e('Add the BreadcrumbsList Schema into Json-LD including all parent categories.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 row mb-1 ml-1">
                                            <div class="checker col-sm-12 row my-2 py-1">
                                                <div class="col-sm-12 p-0 sq-switch sq-switch-sm">
                                                    <input type="hidden" name="sq_jsonld_clearcode" value="0"/>
                                                    <input type="checkbox" id="sq_jsonld_clearcode" name="sq_jsonld_clearcode" class="sq-switch" <?php echo(SQ_Classes_Helpers_Tools::getOption('sq_jsonld_clearcode') ? 'checked="checked"' : '') ?> value="1"/>
                                                    <label for="sq_jsonld_clearcode" class="ml-2"><?php _e('Remove other Json-LD from page', _SQ_PLUGIN_NAME_); ?></label>
                                                    <div class="offset-1 small text-black-50"><?php _e('Clear the Json-LD from other plugins and theme to avoid duplicate schemas.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 my-3 p-0">
                            <?php if (!SQ_Classes_Helpers_Tools::getOption('sq_seoexpert')) { ?>
                                <div class="py-0 float-right text-right m-2">
                                    <button type="button" class="show_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0"><?php _e('Show Advanced Options', _SQ_PLUGIN_NAME_); ?></button>
                                    <button type="button" class="hide_advanced btn rounded-0 btn-link text-black-50 btn-sm p-0 pr-2 m-0" style="display: none"><?php _e('Hide Advanced Options', _SQ_PLUGIN_NAME_); ?></button>
                                </div>
                            <?php } ?>
                            <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php _e('Save Settings', _SQ_PLUGIN_NAME_); ?></button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="sq_col_side sticky">
                <div class="card col-sm-12 p-0">
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockSupport')->init(); ?>
                    <?php echo SQ_Classes_ObjController::getClass('SQ_Core_BlockAssistant')->init(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
