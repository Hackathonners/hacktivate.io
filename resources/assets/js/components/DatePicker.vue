<template>
    <masked-input v-model="date" placeholder="yyyy-mm-dd" mask="1111-11-11"/>
</template>

<script>

    export default {
        props: {
            value: {
                type: String,
                required: true
            },
        },
        data() {
            return {
                date: this.value,
            };
        },
    }
</script>
