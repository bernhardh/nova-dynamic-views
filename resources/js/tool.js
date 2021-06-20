Nova.booting((Vue) => {
    const components = [
        'attach-header',
        'create-header',
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
              '<component :is="comp.name" v-bind="comp.meta"></component>' +
              '</span></div>',

            data() {
                return {
                    customComponents: [],
                    compClass: '',
                    compName: comp
                }
            },

            mounted() {
                let url = '/nova-vendor/nova-dynamic-views/' + this.resourceName + '/' + this.compName;
                if(this.$route.params && this.$route.params.resourceId) {
                    url+= '?id=' + this.$route.params.resourceId
                }

                Nova.request().get(url)
                    .then(res => {
                        let items = res.data.items || []
                        if(items) {
                            for(let i in items) {
                                for(let j in this.$props) {
                                    if(!items[i].meta) items[i].meta = {}
                                    items[i].meta[j] = this[j]
                                }
                            }
                        }
                        this.customComponents = items
                        this.compClass = res.data.class
                    })
            }
        })
    })
})
