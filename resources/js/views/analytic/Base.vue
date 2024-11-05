<template>
    <v-row justify="center">
        <v-col cols="11">
            <sparkline></sparkline>
        </v-col>
        <v-col cols="11">
            <v-row justify="center">
                <v-col cols="auto" class="text-center" v-for="item in 3">
                    <v-progress-circular
                        :key="item"
                        model-value="50"
                        :size="100"
                        :width="15"
                        color="blue"
                    >
                        Техника
                    </v-progress-circular>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script lang="ts">
import Sparkline from "./components/Sparkline.vue";
export default {
    name: "Base",
    components: {
        Sparkline
    },

    setup(props, ctx) {

    },
}

</script>

<style scoped>

</style>
