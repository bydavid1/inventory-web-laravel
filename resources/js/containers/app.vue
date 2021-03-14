<template>
    <div>
        <vmenu/>
        <div class="app-wrapper">
            <div class="app-content pt-3 p-md-3 p-lg-4">
                <div class="container-xl">
                    <vheader>

                    </vheader>
                    <router-view></router-view>
                </div>
            </div>
            <vfooter/>
        </div>
    </div>
</template>

<script>
import vheader from '../components/page-header'
import home from '../views/Home'
import vfooter from '../components/footer'
import vmenu from '../components/menu'

export default {
    name: 'app',
    components: {
        vheader,
        home,
        vfooter,
        vmenu
    }
}
</script>
