<template>

</template>

<script>
export default {
    name: "Prova.vue",
    methods: {
        filterprofessionals() {
            this.professionals = [];
            // selezionati entrambi
            if(this.checkedReview.length > 0 && this.checkedNumberReview.length > 0 ){
                this.checkedReview.forEach( (check, index) => {
                    let average = check;
                    let rangeMin = this.checkedNumberReview[index];
                    if( rangeMin == undefined){
                        rangeMin = '';
                    }
                    const params = {
                        average : average,
                        rangeMin : rangeMin,
                    };
                    axios.get('/api/filter', {params}).then( res => {
                        res.data.results.filter( professional =>{
                            if(!this.professionals.some( prof => prof.id == professional.id)){
                                this.professionals.push(professional);
                            }
                        })
                    });
                });
                this.checkedNumberReview.forEach( (numb, index) => {
                    let average = this.checkedReview[index];
                    let rangeMin = numb;
                    if( average == undefined){
                        average = '';
                    }
                    const params = {
                        average : average,
                        rangeMin : rangeMin,
                    };
                    axios.get('/api/filter', {params}).then( res => {
                        res.data.results.filter( professional =>{
                            if(!this.professionals.some( prof => prof.id == professional.id)){
                                this.professionals.push(professional);
                            }
                        })
                    });
                })
            } else if (this.checkedReview.length > 0 && this.checkedNumberReview.length == 0){
                // selezionato solo media voto
                this.professionals = [];
                //funcione per solo media
            } else if (this.checkedReview.length == 0 && this.checkedNumberReview.length > 0){
                //selezionato solo numero recensioni
                this.professionals = [];
                // funzione per solo numer rec
            } else {
                this.professional =[];
                this.getprofessionals();
            }

        }
    },
    data() {
        return {
            checkedReview: [],
            checkedNumberReview : [],
            professionals : [],
        };
    }
};
</script>

<style scoped>

</style>
