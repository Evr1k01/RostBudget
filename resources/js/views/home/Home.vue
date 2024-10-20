<template>
    <v-app-bar class="position-fixed">
        <v-row justify="center" align="center">
            <v-col cols="2" class="text-start">
                <v-img :src="Logo" class="header__logo"></v-img>
            </v-col>
            <v-col cols="10" class="text-end">
                <v-btn>Выход</v-btn>
            </v-col>
        </v-row>
    </v-app-bar>
</template>

<script lang="ts">
import Logo from '@/assets/icons/LogoWhite.png'
export default {
    name: "Home",
    data: () => ({
        Logo
    }),

    setup(props, ctx) {

    },
}
</script>


<style scoped>

</style>
