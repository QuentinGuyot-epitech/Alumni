<template>
  <v-card class="ma-2" max-width="340">
    <v-img
      src="https://i.picsum.photos/id/76/350/165.jpg?hmac=ZjK8NEtD9P2HV5RJN2IS6WEqWj17QZp3nYSiBMITRO0"
      height="150px"
    ></v-img>
    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex justify-content-between">
        <div>
          <v-card-title>{{ event.title }}</v-card-title>
          <v-card-subtitle class="d-flex flex-column">
            <div>{{ new Date(event.start_date).toLocaleString() }}</div>
            <div class="green--text text--darken-1">{{ event.location }}</div>
            <div v-if="user.id == event.organiser_user_id" id="delete-icon">
              <v-tooltip left color="red">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn x-small fab @click="deleteEvent(event.id)">
                    <v-icon color="red darken-2" v-bind="attrs" v-on="on">mdi-trash-can-outline</v-icon>
                  </v-btn>
                </template>
                <span>Delete Event</span>
              </v-tooltip>
            </div>
          </v-card-subtitle>
        </div>
      </div>
      <v-tooltip bottom :disabled="participantCount != event.max_attendees">
        <template v-slot:activator="{ on }">
          <div v-on="on" class="d-inline-block">
            <div v-if="user.id == event.organiser_user_id">
              <EditEvent :event="event"></EditEvent>
            </div>
            <v-btn
              class="mr-4 white--text pl-2"
              :color="attending ? 'green' : 'blue'"
              :disabled="participantCount >= event.max_attendees && !attending"
              @click="attendEvent(event.max_attendees)"
            >
              <v-icon>{{ attending ? 'mdi-check' : 'mdi-plus' }}</v-icon>
              {{ attending ? 'Attending' : 'Attend' }}
            </v-btn>
          </div>
        </template>
        <span>Sorry, this event is fully booked</span>
      </v-tooltip>
    </div>

    <v-card-actions>
      <v-btn @click="show = !show" color="orange lighten-1" text>See details</v-btn>

      <v-spacer></v-spacer>

      <v-btn icon @click="show = !show">
        <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
      </v-btn>
    </v-card-actions>

    <v-expand-transition>
      <div v-show="show">
        <v-divider class="my-0"></v-divider>

        <v-card-text>{{ event.description }}</v-card-text>
        <v-divider class="my-0"></v-divider>
        <v-card-text
          v-if="participantCount == 0"
        >Be first to attend this event ({{event.max_attendees}} spots available)</v-card-text>
        <v-card-text v-else-if="participantCount <= 1">
          <strong>{{ participantCount }} / {{ event.max_attendees }}</strong> people is attending this event
        </v-card-text>
        <v-card-text v-else>
          <strong>{{ participantCount }} / {{ event.max_attendees }}</strong> people are attending this event
        </v-card-text>
      </div>
    </v-expand-transition>
  </v-card>
</template>

<script>
import EditEvent from "@/components/EventComponents/EditEvent";
import { mapActions } from "vuex";

export default {
  name: "EventCard",
  props: ["event", "user"],
  components: {
    EditEvent,
  },
  data: () => ({
    show: false,
    attending: false,
    // participantCount: 25,
    participantCount: Math.floor(Math.random() * 3),
  }),
  methods: {
    ...mapActions(["deleteEvent"]),
    attendEvent: function (max_attendees) {
      if (this.participantCount <= max_attendees) {
        this.attending = !this.attending;
        if (this.attending) {
          this.participantCount++;
        } else {
          this.participantCount--;
        }
      }
    },
  },
};
</script>

<style scoped>
#delete-icon {
  position: absolute;
  top: 20px;
  right: 20px;
}
</style>