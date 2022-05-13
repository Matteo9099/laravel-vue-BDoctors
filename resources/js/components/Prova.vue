<template>

</template>

<script>
export default {
    name: "Prova.vue",
    methods: {
        filterDoctors() {
            this.doctors = [];
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
                        res.data.results.filter( doctor =>{
                            if(!this.doctors.some( doc => doc.id == doctor.id)){
                                this.doctors.push(doctor);
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
                        res.data.results.filter( doctor =>{
                            if(!this.doctors.some( doc => doc.id == doctor.id)){
                                this.doctors.push(doctor);
                            }
                        })
                    });
                })
            } else if (this.checkedReview.length > 0 && this.checkedNumberReview.length == 0){
                // selezionato solo media voto
                this.doctors = [];
                //funcione per solo media
            } else if (this.checkedReview.length == 0 && this.checkedNumberReview.length > 0){
                //selezionato solo numero recensioni
                this.doctors = [];
                // funzione per solo numer rec
            } else {
                this.doctor =[];
                this.getDoctors();
            }

        }
    },
    data() {
        return {
            checkedReview: [],
            checkedNumberReview : [],
            doctors : [],
        };
    }
};
</script>

<style scoped>

</style>
