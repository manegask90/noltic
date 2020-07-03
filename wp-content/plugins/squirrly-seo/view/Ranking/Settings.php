<div id="sq_wrap">
    <?php SQ_Classes_ObjController::getClass('SQ_Core_BlockToolbar')->init(); ?>
    <?php do_action('sq_notices'); ?>
    <div class="d-flex flex-row my-0 bg-white" style="clear: both !important;">
        <?php
        if (!current_user_can('sq_manage_focuspages')) {
            echo '<div class="col-sm-12 alert alert-success text-center m-0 p-3">'. __("You do not have permission to access this page. You need Squirrly SEO Admin role.", _SQ_PLUGIN_NAME_).'</div>';
            return;
        }
        ?>
        <?php echo SQ_Classes_ObjController::getClass('SQ_Models_Menu')->getAdminTabs(SQ_Classes_Helpers_Tools::getValue('tab'), 'sq_rankings'); ?>
        <div class="d-flex flex-row flex-nowrap flex-grow-1 bg-white pl-3 pr-0 mr-0">
            <div class="flex-grow-1 mr-3 sq_flex">
                <div class="form-group my-4 col-sm-10 offset-1">
                    <?php echo $view->getView('Connect/GoogleAnalytics'); ?>
                    <?php echo $view->getView('Connect/GoogleSearchConsole'); ?>
                </div>
                <form method="POST">
                    <?php do_action('sq_form_notices'); ?>
                    <?php SQ_Classes_Helpers_Tools::setNonce('sq_ranking_settings', 'sq_nonce'); ?>
                    <input type="hidden" name="action" value="sq_ranking_settings"/>

                    <div class="card col-sm-12 p-0">
                        <div class="card-body p-0 m-0 bg-title rounded-top  row">
                            <div class="card-body p-2 bg-title rounded-top">
                                <div class="sq_icons_content p-3 py-4">
                                    <div class="sq_icons sq_settings_icon m-2"></div>
                                </div>
                                <h3 class="card-title py-4"><?php _e('Rankings Settings', _SQ_PLUGIN_NAME_); ?>:</h3>
                                <div class="card-title-description m-2"></div>
                            </div>
                        </div>
                        <div id="sq_seosettings" class="card col-sm-12 p-0 m-0 border-0 tab-panel border-0">
                            <div class="card-body p-0">
                                <div class="col-sm-12 m-0 p-0">
                                    <div class="card col-sm-12 p-0 border-0 ">

                                        <div class="col-sm-12 pt-0 pb-4 border-bottom tab-panel">


                                            <div class="col-sm-12 row py-2 mx-0 my-3">
                                                <div class="col-sm-4 p-1 pr-3">
                                                    <div class="font-weight-bold"><?php _e('Google Country', _SQ_PLUGIN_NAME_); ?>:</div>
                                                    <div class="small text-black-50"><?php echo __('Select the Google country for which Squirrly will check the Google rank.', _SQ_PLUGIN_NAME_); ?></div>
                                                </div>
                                                <div class="col-sm-8 p-0 input-group">
                                                    <select name="sq_google_country" class="form-control bg-input mb-1">
                                                        <option value="com"><?php _e('Default', _SQ_PLUGIN_NAME_); ?> - Google.com (http://www.google.com/)</option>
                                                        <option value="as"><?php _e('American Samoa', _SQ_PLUGIN_NAME_); ?> (http://www.google.as/)</option>
                                                        <option value="off.ai"><?php _e('Anguilla', _SQ_PLUGIN_NAME_); ?> (http://www.google.off.ai/)</option>
                                                        <option value="com.ag"><?php _e('Antigua and Barbuda', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.ag/)</option>
                                                        <option value="com.ar"><?php _e('Argentina', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.ar/)</option>
                                                        <option value="com.au"><?php _e('Australia', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.au/)</option>
                                                        <option value="at"><?php _e('Austria', _SQ_PLUGIN_NAME_); ?> (http://www.google.at/)</option>
                                                        <option value="az"><?php _e('Azerbaijan', 'seo-rank-reporter'); ?> (http://www.google.az/)</option>
                                                        <option value="be"><?php _e('Belgium', _SQ_PLUGIN_NAME_); ?> (http://www.google.be/)</option>
                                                        <option value="com.br"><?php _e('Brazil', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.br/)</option>
                                                        <option value="vg"><?php _e('British Virgin Islands', _SQ_PLUGIN_NAME_); ?> (http://www.google.vg/)</option>
                                                        <option value="bi"><?php _e('Burundi', _SQ_PLUGIN_NAME_); ?> (http://www.google.bi/)</option>
                                                        <option value="bg"><?php _e('Bulgaria', _SQ_PLUGIN_NAME_); ?> (http://www.google.bg/)</option>
                                                        <option value="ca"><?php _e('Canada', _SQ_PLUGIN_NAME_); ?> (http://www.google.ca/)</option>
                                                        <option value="td"><?php _e('Chad', _SQ_PLUGIN_NAME_); ?> (http://www.google.td/)</option>
                                                        <option value="cl"><?php _e('Chile', _SQ_PLUGIN_NAME_); ?> (http://www.google.cl/)</option>
                                                        <option value="com.co"><?php _e('Colombia', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.co/)</option>
                                                        <option value="co.cr"><?php _e('Costa Rica', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.cr/)</option>
                                                        <option value="ci"><?php _e('Côte d\'Ivoire', _SQ_PLUGIN_NAME_); ?> (http://www.google.ci/)</option>
                                                        <option value="com.cu"><?php _e('Cuba', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.cu/)</option>
                                                        <option value="cz"><?php _e('Czech Republic', _SQ_PLUGIN_NAME_); ?> (http://www.google.cz/)</option>
                                                        <option value="cd"><?php _e('Dem. Rep. of the Congo', _SQ_PLUGIN_NAME_); ?> (http://www.google.cd/)</option>
                                                        <option value="dk"><?php _e('Denmark', _SQ_PLUGIN_NAME_); ?> (http://www.google.dk/)</option>
                                                        <option value="dj"><?php _e('Djibouti', _SQ_PLUGIN_NAME_); ?> (http://www.google.dj/)</option>
                                                        <option value="com.do"><?php _e('Dominican Republic', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.do/)</option>
                                                        <option value="com.ec"><?php _e('Ecuador', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.ec/)</option>
                                                        <option value="com.sv"><?php _e('El Salvador', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.sv/)</option>
                                                        <option value="ee"><?php _e('Estonia', _SQ_PLUGIN_NAME_); ?> (http://www.google.ee/)</option>
                                                        <option value="fm"><?php _e('Federated States of Micronesia', _SQ_PLUGIN_NAME_); ?> (http://www.google.fm/)</option>
                                                        <option value="com.fj"><?php _e('Fiji', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.fj/)</option>
                                                        <option value="fi"><?php _e('Finland', _SQ_PLUGIN_NAME_); ?> (http://www.google.fi/)</option>
                                                        <option value="fr"><?php _e('France', _SQ_PLUGIN_NAME_); ?> (http://www.google.fr/)</option>
                                                        <option value="gm"><?php _e('The Gambia', _SQ_PLUGIN_NAME_); ?> (http://www.google.gm/)</option>
                                                        <option value="ge"><?php _e('Georgia', _SQ_PLUGIN_NAME_); ?> (http://www.google.ge/)</option>
                                                        <option value="de"><?php _e('Germany', _SQ_PLUGIN_NAME_); ?> (http://www.google.de/)</option>
                                                        <option value="com.gh"><?php _e('Ghana ', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.gh/)</option>
                                                        <option value="com.gi"><?php _e('Gibraltar', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.gi/)</option>
                                                        <option value="com.gr"><?php _e('Greece', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.gr/)</option>
                                                        <option value="gl"><?php _e('Greenland', _SQ_PLUGIN_NAME_); ?> (http://www.google.gl/)</option>
                                                        <option value="gg"><?php _e('Guernsey', _SQ_PLUGIN_NAME_); ?> (http://www.google.gg/)</option>
                                                        <option value="hn"><?php _e('Honduras', _SQ_PLUGIN_NAME_); ?> (http://www.google.hn/)</option>
                                                        <option value="com.hk"><?php _e('Hong Kong', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.hk/)</option>
                                                        <option value="co.hu"><?php _e('Hungary', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.hu/)</option>
                                                        <option value="co.in"><?php _e('India', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.in/)</option>
                                                        <option value="co.id"><?php _e('Indonesia', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.id/)</option>
                                                        <option value="ie"><?php _e('Ireland', _SQ_PLUGIN_NAME_); ?> (http://www.google.ie/)</option>
                                                        <option value="co.im"><?php _e('Isle of Man', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.im/)</option>
                                                        <option value="co.il"><?php _e('Israel', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.il/)</option>
                                                        <option value="it"><?php _e('Italy', _SQ_PLUGIN_NAME_); ?> (http://www.google.it/)</option>
                                                        <option value="com.jm"><?php _e('Jamaica', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.jm/)</option>
                                                        <option value="co.jp"><?php _e('Japan', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.jp/)</option>
                                                        <option value="co.je"><?php _e('Jersey', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.je/)</option>
                                                        <option value="kz"><?php _e('Kazakhstan', _SQ_PLUGIN_NAME_); ?> (http://www.google.kz/)</option>
                                                        <option value="co.kr"><?php _e('Korea', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.kr/)</option>
                                                        <option value="lv"><?php _e('Latvia', _SQ_PLUGIN_NAME_); ?> (http://www.google.lv/)</option>
                                                        <option value="co.ls"><?php _e('Lesotho', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.ls/)</option>
                                                        <option value="li"><?php _e('Liechtenstein', _SQ_PLUGIN_NAME_); ?> (http://www.google.li/)</option>
                                                        <option value="lt"><?php _e('Lithuania', _SQ_PLUGIN_NAME_); ?> (http://www.google.lt/)</option>
                                                        <option value="lu"><?php _e('Luxembourg', _SQ_PLUGIN_NAME_); ?> (http://www.google.lu/)</option>
                                                        <option value="mw"><?php _e('Malawi', _SQ_PLUGIN_NAME_); ?> (http://www.google.mw/)</option>
                                                        <option value="com.my"><?php _e('Malaysia', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.my/)</option>
                                                        <option value="com.mt"><?php _e('Malta', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.mt/)</option>
                                                        <option value="mu"><?php _e('Mauritius', _SQ_PLUGIN_NAME_); ?> (http://www.google.mu/)</option>
                                                        <option value="com.mx"><?php _e('México', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.mx/)</option>
                                                        <option value="ms"><?php _e('Montserrat', _SQ_PLUGIN_NAME_); ?> (http://www.google.ms/)</option>
                                                        <option value="com.na"><?php _e('Namibia', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.na/)</option>
                                                        <option value="com.np"><?php _e('Nepal', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.np/)</option>
                                                        <option value="nl"><?php _e('Netherlands', _SQ_PLUGIN_NAME_); ?> (http://www.google.nl/)</option>
                                                        <option value="co.nz"><?php _e('New Zealand', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.nz/)</option>
                                                        <option value="com.ni"><?php _e('Nicaragua', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.ni/)</option>
                                                        <option value="com.ng"><?php _e('Nigeria', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.ng/)</option>
                                                        <option value="com.nf"><?php _e('Norfolk Island', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.nf/)</option>
                                                        <option value="no"><?php _e('Norway', _SQ_PLUGIN_NAME_); ?> (http://www.google.no/)</option>
                                                        <option value="com.pk"><?php _e('Pakistan', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.pk/)</option>
                                                        <option value="com.pa"><?php _e('Panamá', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.pa/)</option>
                                                        <option value="com.py"><?php _e('Paraguay', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.py/)</option>
                                                        <option value="com.pe"><?php _e('Perú', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.pe/)</option>
                                                        <option value="com.ph"><?php _e('Philippines', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.ph/)</option>
                                                        <option value="pn"><?php _e('Pitcairn Islands', _SQ_PLUGIN_NAME_); ?> (http://www.google.pn/)</option>
                                                        <option value="pl"><?php _e('Poland', _SQ_PLUGIN_NAME_); ?> (http://www.google.pl/)</option>
                                                        <option value="pt"><?php _e('Portugal', _SQ_PLUGIN_NAME_); ?> (http://www.google.pt/)</option>
                                                        <option value="com.pr"><?php _e('Puerto Rico', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.pr/)</option>
                                                        <option value="cg"><?php _e('Rep. of the Congo', _SQ_PLUGIN_NAME_); ?> (http://www.google.cg/)</option>
                                                        <option value="ro"><?php _e('Romania', _SQ_PLUGIN_NAME_); ?> (http://www.google.ro/)</option>
                                                        <option value="ru"><?php _e('Russia', _SQ_PLUGIN_NAME_); ?> (http://www.google.ru/)</option>
                                                        <option value="rw"><?php _e('Rwanda', _SQ_PLUGIN_NAME_); ?> (http://www.google.rw/)</option>
                                                        <option value="sh"><?php _e('Saint Helena', _SQ_PLUGIN_NAME_); ?> (http://www.google.sh/)</option>
                                                        <option value="sm"><?php _e('San Marino', _SQ_PLUGIN_NAME_); ?> (http://www.google.sm/)</option>
                                                        <option value="com.sa"><?php _e('Saudi Arabia', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.sa/)</option>
                                                        <option value="com.sg"><?php _e('Singapore', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.sg/)</option>
                                                        <option value="sk"><?php _e('Slovakia', _SQ_PLUGIN_NAME_); ?> (http://www.google.sk/)</option>
                                                        <option value="co.za"><?php _e('South Africa', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.za/)</option>
                                                        <option value="es"><?php _e('Spain', _SQ_PLUGIN_NAME_); ?> (http://www.google.es/)</option>
                                                        <option value="lk"><?php _e('Sri Lanka', _SQ_PLUGIN_NAME_); ?> (http://www.google.lk/)</option>
                                                        <option value="se"><?php _e('Sweden', _SQ_PLUGIN_NAME_); ?> (http://www.google.se/)</option>
                                                        <option value="ch"><?php _e('Switzerland', _SQ_PLUGIN_NAME_); ?> (http://www.google.ch/)</option>
                                                        <option value="com.tw"><?php _e('Taiwan', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.tw/)</option>
                                                        <option value="co.th"><?php _e('Thailand', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.th/)</option>
                                                        <option value="tt"><?php _e('Trinidad and Tobago', _SQ_PLUGIN_NAME_); ?> (http://www.google.tt/)</option>
                                                        <option value="com.tr"><?php _e('Turkey', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.tr/)</option>
                                                        <option value="com.ua"><?php _e('Ukraine', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.ua/)</option>
                                                        <option value="ae"><?php _e('United Arab Emirates', _SQ_PLUGIN_NAME_); ?> (http://www.google.ae/)</option>
                                                        <option value="co.uk"><?php _e('United Kingdom', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.uk/)</option>
                                                        <option value="us"><?php _e('United States', _SQ_PLUGIN_NAME_); ?> (http://www.google.us/)</option>
                                                        <option value="com.uy"><?php _e('Uruguay', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.uy/)</option>
                                                        <option value="uz"><?php _e('Uzbekistan', _SQ_PLUGIN_NAME_); ?> (http://www.google.uz/)</option>
                                                        <option value="vu"><?php _e('Vanuatu', _SQ_PLUGIN_NAME_); ?> (http://www.google.vu/)</option>
                                                        <option value="co.ve"><?php _e('Venezuela', _SQ_PLUGIN_NAME_); ?> (http://www.google.co.ve/)</option>
                                                        <option value="com.vn"><?php _e('Vietnam', _SQ_PLUGIN_NAME_); ?> (http://www.google.com.vn/)</option>
                                                    </select>
                                                    <script>jQuery('select[name=sq_google_country]').val('<?php echo SQ_Classes_Helpers_Tools::getOption('sq_google_country')?>').attr('selected', true);</script>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12 my-3 p-0">
                        <button type="submit" class="btn rounded-0 btn-success btn-lg px-5 mx-4"><?php _e('Save Settings', _SQ_PLUGIN_NAME_); ?></button>
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
