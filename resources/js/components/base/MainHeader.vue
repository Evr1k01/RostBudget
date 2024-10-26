<template>
    <v-app-bar class="position-fixed">
        <v-app-bar-nav-icon @click.stop="toggleDrawer"></v-app-bar-nav-icon>
        <v-toolbar-title>
            <router-link to="/home"><v-img :src="logo" class="header__logo"></v-img></router-link>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn @click="logout">Выход</v-btn>
    </v-app-bar>
</template>

<script lang="ts">
import {ref} from "vue";
import mainLogo from '../../assets/icons/LogoWhite.png'
import {useRouter} from "vue-router";
import {useStore} from "vuex";

export default {
    name: "MainHeader",
    emits: ['changeDrawer'],

    setup(props, ctx) {

        const router = useRouter()
        const store = useStore()
        const drawer = ref<boolean>(true)
        const logo = ref(mainLogo)

        const logout = () => {
            store.dispatch('loggedUser/logout').then(() => {
                router.push({name: 'Start'})
            })
        }

        const toggleDrawer = () => {
            drawer.value = !drawer.value;
            ctx.emit('changeDrawer', drawer.value)
        }

        return {
            logo,
            drawer,
            logout,
            toggleDrawer
        }
    },
}

</script>

<style scoped>

</style>
