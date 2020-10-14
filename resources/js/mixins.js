export default {
    props: ['resourceName'],

    template: `<div>
    <div v-for="(value, name) in customComponents">
      <component :is="name" v-bind="$props" v-bind="value"></component>
    </div>
  </div>`,

    data() {
        return {
            customComponents: []
        }
    },

    mounted() {
        Nova.request().get('/nova-vendor/nova-dynamic-views/' + this.resourceName + '/' + this.viewName + '/' + this.area)
            .then(res => {
                this.customComponents = res.data
            })
    }
}
