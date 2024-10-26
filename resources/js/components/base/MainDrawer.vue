<template>
    <v-navigation-drawer
        :location="drawerLocation"
        v-model="drawer"
    >
        <v-list>
            <v-list-item
                v-for="item in drawerItems"
                :prepend-icon="item.icon"
                :title="item.title"
                :to="item.to">
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script lang="ts">
import {useDisplay} from "vuetify";
import {computed, ref, toRef} from "vue";

export default {
    name: "MainDrawer",
    props: {
        drawer: Boolean
    },

    setup(props, ctx) {

        const drawer = toRef(props, 'drawer')

        const display = useDisplay()

        const drawerLocation = computed(() => display.mobile.value ? 'bottom' : 'start')
        const drawerItems = ref([
            // {
            //     icon: 'mdi-book',
            //     title: 'Обзор за месяц',
            //     to: 'home'
            // },
            //
            // {
            //     icon: 'mdi-book',
            //     title: 'Месячный обзор',
            //     to: 'home'
            // },
            //
            // {
            //     icon: 'mdi-book',
            //     title: 'Статистика',
            //     to: 'home'
            // }
        ])

        return {
            drawer,
            drawerLocation,
            drawerItems
        }
    },
}
</script>


<style scoped>

</style>
