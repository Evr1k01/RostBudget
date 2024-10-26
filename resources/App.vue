<template>
    <v-app>
        <main-header @changeDrawer="setDrawerValue" v-if="isLogged"></main-header>
        <main-drawer :drawer="drawer" v-if="isLogged"></main-drawer>
        <core-view/>
    </v-app>
</template>

<script lang="ts">
import CoreView from "./js/components/CoreView.vue";
import MainHeader from "./js/components/base/MainHeader.vue";
import MainDrawer from "./js/components/base/MainDrawer.vue";
import {computed, ref} from "vue";
import {useStore} from "vuex";
export default {
    name: "App",
    components: {
        CoreView,
        MainHeader,
        MainDrawer
    },

    setup(props, ctx) {
        const store = useStore()
        const isLogged = computed(() => store.getters["loggedUser/isLogged"])

        const drawer = ref<boolean>(true)
        const setDrawerValue = (value: boolean) => {
            drawer.value = value
        }

        return {
            drawer,
            isLogged,
            setDrawerValue
        }
    },
}
</script>

<style scoped>

</style>
