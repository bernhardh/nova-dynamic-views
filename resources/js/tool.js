Nova.booting((Vue) => {
    const components = [
        'attach-header',
        'create-header',
        'dashboard-header',
        'detail-header',
        'detail-toolbar',
        'index-header',
        'index-toolbar',
        'lens-header',
        'update-attach-header',
        'update-header'
    ];

    components.forEach((comp) => {
        Vue.component('custom-' + comp, {
            props: ['resourceName'],

            template: '<div :class="compClass"><span v-for="(comp, index) in customComponents" :key="index">' +
              '<component :is="comp.name" v-bind="$props" v-bind="comp.meta"></component>' +
              '</span></div>',

            data() {
                return {
                    customComponents: [],
                    compClass: '',
                    compName: comp
                }
            },

            mounted() {
                Nova.request().get('/nova-vendor/nova-dynamic-views/' + this.resourceName + '/' + this.compName)
                    .then(res => {
                        this.customComponents = res.data.items
                        this.compClass = res.data.class
                    })
            }
        })
    })
})
