<style>
    @media only screen and (max-width: 992px) {
        .home-text {left:calc(50% - 150px);}
        #vApp {background-image: url('<?php echo site_url(); ?>images/home_mobile.jpg');}
    }
    @media only screen and (min-width: 993px) {
        .home-text {left:calc(50% - 25px);}
        #vApp {background-image: url('<?php echo site_url(); ?>images/home.jpg');}
    }
</style>

<div class="content-wrapper" id="vApp" style="padding-bottom:50px; background-repeat:no-repeat; background-size:100%; opacity:0.2;">
</div>

<div class="text-center home-text" style="position:absolute; top:100px; width:300px;">
    <h1 style="font-weight: 600;">Smart Booking</h1><br>
    <?php echo _r('Hello,', 'ยินดีต้อนรับ '); ?> <?php $s = $this->session->userdata('user_data'); echo $s['name']; ?><br><br>
</div>