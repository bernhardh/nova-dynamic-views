<template>
  <div>
    <div v-for="comp in customComponents">
      <component :is="comp" :resource-name="resourceName"></component>
    </div>
  </div>
</template>

<script>
export default {
  props: ['resourceName'],

  data() {
    return {
      customComponents: []
    }
  },

  mounted() {
    Nova.request().get("/nova-vendor/nova-dynamic-views/" + this.resourceName)
        .then(res => {
          this.customComponents = res.data && res.data.header
        })
  }
}
</script>
