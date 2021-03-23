<?php

$db->where("status",1);
$db->orderBy("id","Desc");
$fetch_notice = $db->getOne("p30web_notic");

if($db->count != 0) { ?>

    <div class="mtsnb mtsnb-sp-right mtsnb-button mtsnb-bottom mtsnb-fixed mtsnb-shown" id="mtsnb-24" data-mtsnb-id="22" data-bar-animation="" data-bar-content-animation="mtsnb-zoomIn" data-sp-selector="">
        <div class="mtsnb-container-outer">
            <div class="mtsnb-container mtsnb-clearfix" style="padding-top: 10px;padding-bottom: 10px;text-align: center;">
                <div class="mtsnb-button-type mtsnb-content mtsnb-animated mtsnb-zoomIn" data-mtsnb-variation="none">
                    <span class="mtsnb-text"> <?php echo $fetch_notice['title'] ?></span>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__brand">
        <a class="kt-header-mobile__logo" href="index-2.html">
            <img alt="Logo" width="50px" src="/Attachment/img/settingslogo1565647848.png">
        </a>
        <div class="kt-header-mobile__nav">
        </div>
    </div>
    <div class="kt-header-mobile__toolbar">

        <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                    class="flaticon-more-1"></i></button>
    </div>
</div>
<!-- end:: Header Mobile -->