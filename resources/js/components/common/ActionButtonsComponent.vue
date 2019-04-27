<template>
<div class="actionButtons">
        <button
        v-for="(button, index) in myProps" :key="index"
        :class="button.class" @click="actionsHandler(button.action)">
            <i v-if="button.icon" :class="button.icon" aria-hidden="true"> </i>
            {{button.name}}
            </button>

</div>
</template>

<script>

export default {
    props: ["actionButtons"],

    data: function() {
        return {
            myProps: this.actionButtons
        }
    },

    methods: {
        actionsHandler(action) {
            this.$emit('action', action)
        }
    }
}
</script>

<style>

.actionButtons {
    display: flex; width: 100%;justify-content:center;
}
.btn-submit {
  border-radius: 0;
  width: 100%;
}


</style>
