<template>
    <v-app-bar class="position-fixed">
        <v-app-bar-nav-icon @click="toggleDrawer"></v-app-bar-nav-icon>
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

    setup(props, ctx) {

        const router = useRouter()
        const store = useStore()
        const logo = ref(mainLogo)

        const logout = () => {
            store.dispatch('loggedUser/logout').then(() => {
                router.push({name: 'Start'})
            })
        }

        const toggleDrawer = () => {
            store.dispatch('system/setDrawer')
        }

        return {
            logo,
            logout,
            toggleDrawer
        }
    },
}

</script>

<style scoped>

</style>
