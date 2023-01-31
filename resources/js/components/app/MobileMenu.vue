<template>
    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Midone - HTML Admin Template" class="w-6" src="#">
            </a>
            <a href="javascript:;" class="mobile-menu-toggler">
                <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
            </a>
        </div>
        <div class="scrollable">
            <a href="javascript:;" class="mobile-menu-toggler">
                <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i>
            </a>
            <ul class="scrollable__content py-2">
                <li class="menu__devider my-6"></li>
                <li>
                    <a href="#" class="menu menu--active">
                        <div class="menu__icon">
                            <i data-lucide=""></i>
                        </div>
                        <div class="menu__title">
                            <i data-lucide="chevron-down" class="menu__sub-icon"></i>
                        </div>
                    </a>
                    <ul class="menu__sub-open">
                        <li>
                            <a href="javascript:;" class="menu">
                                <div class="menu__icon">
                                    <i data-lucide="activity"></i>
                                </div>
                                <div class="menu__title">
                                    <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                                </div>
                            </a>
                            <ul class="menu__sub-open">
                                <li>
                                    <a href="menu">
                                        <div class="menu__icon">
                                            <i data-lucide="zap"></i>
                                        </div>
                                        <div class="menu__title">Lorem</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Mobile Menu -->

</template>