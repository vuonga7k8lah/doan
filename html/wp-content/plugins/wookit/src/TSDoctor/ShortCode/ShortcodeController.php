<?php

namespace MyShopKitPopupSmartBarSlideIn\TSDoctor\ShortCode;

class ShortcodeController
{
    public function __construct()
    {
        add_shortcode('FormRegisterMaster', [$this, 'handle']);
    }

    public function handle()
    {
        ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <?php
    }
}
