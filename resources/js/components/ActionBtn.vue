<template>
    <a :href="href"
       :class="btn_class?btn_class:'ms-1 btn-edit'"
       :target="target?'_black':''"
       @click="$emit('click')"><span id="top"
        class="tooltip-text tooltip-text2 btn-warning"
        style="right: -30px;">{{ tooltip_text }}</span><i
        :class="icon"></i></a>

</template>

<script>
export default {
    props: ["label", "icon", 'tooltip_text', 'href','target','btn_class', 'btn-warning', 'btn-warning i',
'rest-btn', 'rest-btn i','rest-btn:hover'],
    data() {
        return {
            methods: {}
        }
    }
}
</script>
