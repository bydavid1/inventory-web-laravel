<template>
    <div class="app-card mb-4 border-left-decoration">
        <div class="inner">
            <div class="app-card-body p-3 p-lg-4">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h4 class="content-header-title float-left pr-1 mb-0">{{ pagetitle }}</h4>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb bg-transparent p-0 mb-0">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Item page 1</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    <a href="#">Item page 2</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <slot name="tools"></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name : 'page-header',
    props : ['pagetitle']
}
</script>
