<template>
    <div>
        <div>
            <gmap-map
                :center="markers[0].position"
                :zoom="12"
                style="width:100%;  height: 400px;" 
            >
                <gmap-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    @click="center=m.position"
                ></gmap-marker>
            </gmap-map>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import axios from 'axios';

export default {
    props: ["marker"],
    name: "GoogleMap",
    
    data() {
        return {
            // default to Paris
            center: { lat: 48.866667, lng: 2.333333 },
            markers: []
        }
    },

    mounted() {
        this.geolocate();
    },

    created() {
        this.fetchAllJobs();
        this.geocode();
    },

    methods: {

        ...mapActions(["fetchAllJobs"]),
        // receives a place object via the autocomplete component
        
        geolocate() {
            navigator.geolocation.getCurrentPosition(position => {
                this.center = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
                };
            });
        },

        geocode() {
            const fullAddress = [];
            fullAddress.push(this.marker.street_address, this.marker.city, this.marker.postal_code);
            const strFullAddress = fullAddress.toString();

            axios.get('https://cors-anywhere.herokuapp.com/https://maps.googleapis.com/maps/api/geocode/json',
                {
                    params: {
                        address: strFullAddress,
                        key: 'AIzaSyCcQF8GcEbw96HCPndWKyX9fjgIk1N38M0'
                    }
                })
            .then(response => {
                console.log(response.data)
                if(response.data.results.length !== 0 && Array.isArray(response.data.results)) {
                    const addressCoord = response.data.results[0].geometry.location;
                    const marker = { position: addressCoord };
                    this.markers.push(marker);
                }
            })
            .catch(error => {
                console.log(error)
            })
        },
    },

    computed: {
        ...mapGetters(["getAllJobs", "user"]),
    }
};
</script>