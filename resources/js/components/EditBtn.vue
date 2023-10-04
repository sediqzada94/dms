<template>
    <a
       class="ms-1 btn-edit hover-text:hover tooltip-text2"
       @click="$emit('click')"><span id="top"
        class="tooltip-text tooltip-text2"
        style="right: -30px;">{{ tooltip_text }}</span><i
        class="fadeIn animated bx bx-edit"></i></a>

</template>

<script>
export default {
    props: ['tooltip_text'],
    data() {
        return {
            methods: {}
        }
    }
}
</script>
