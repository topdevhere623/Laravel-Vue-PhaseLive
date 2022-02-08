<script>
    let id = 0;
    export default {
        data () {
            return {
                metaSelectionMode:false,
                image:{'uploaded':null,'input':null},
                content: null,
                repeater:{
                    slider:[
                    ],
                    text:[
                    ],
                    dropdown:[
                    ]
                }
            }
        },

        mounted: function() {

            axios.get('/admin/meta/get/'+$('#page_id').val()).then(response => {
                if(response.data) {
                    this.repeater = response.data.repeater;
                    this.image = response.data.image;
                    this.content = response.data.content

                    console.log(this.image);
                } else {
                    reject();
                }
            });
        },

        methods: {
            addMeta(){
                this.metaSelectionMode = true;
            },
            selectMetaType(event){
                this.metaSelectionMode = false;

                if(event.target.value=='slider'){
                    this.repeater.slider.push({
                        id:this.repeater.slider.length,
                        name:'',
                        uploaded:[],
                        inputs:[]
                    })
                }else if(event.target.value=='text'){
                    this.repeater.text.push({
                        id:this.repeater.text.length,
                        name:'',
                        inputs:[]
                    });
                }else if(event.target.value=='dropdown'){
                    this.repeater.dropdown.push({
                        id:this.repeater.dropdown.length,
                        name:'',
                        inputs:[]
                    });
                }
            },
            addToRepeater(idx,type){
                if(type=='text'){
                    this.repeater[type][idx].inputs.push({value:''});
                }else if(type=='dropdown'){
                    this.repeater[type][idx].inputs.push({key:'',value:''});
                }else if(type=='slider'){
                    this.repeater[type][idx].inputs.push({input:null,uploaded:null});
                }
            },
            removeFromARepeater(idx,type,fieldIdx){
                this.repeater[type][idx].inputs.splice(fieldIdx,1);
            },
            removeRepeaterBlock(type,repeaterIdx){
                this.repeater[type].splice(repeaterIdx,1);
            }
        },
        created: function() {
            
        }
    }
</script>

<style lang="scss" scoped>
   
</style>
