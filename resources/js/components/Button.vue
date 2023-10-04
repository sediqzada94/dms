<template>
    <a :href="href"
       :class="btn_class?btn_class:'btn btn-outline-success px-4 detail-btn ms-1 mb-1'"
       @click="$emit('click')"
        :target="target?'_black':''"
         :style="(loading || disable)?'pointer-events: none;color:black;background-color:white;border:black':''"
    >
    <span id="top"
    :class="tooltip_class?tooltip_class:'tooltip-text tooltip-text3'"
    style="right: -30px;">{{ tooltip_text }}</span>
        <span v-if="loading" class="spinner-border spinner-border-sm text-info mt-2" role="status" aria-hidden="true"></span>
        <i
    :class="icon"></i> {{label}}</a>
</template>

<script>
export default {
    props: ["label", "icon", 'tooltip_text', 'href','btn_class','target','tooltip_class','disable','loading'],
    data() {
        return {
            methods: {}
        }
    }
}
</script>

<style>

</style>

