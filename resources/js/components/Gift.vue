<template>
  <div>
    <b-card :title="this.title" :sub-title="'$' + this.price" class="mt-2 mb-2">
      <b-card-text v-if="this.description">{{ this.description }}</b-card-text>
      <b-card-text>
        <b-link :href="this.link" v-if="this.link">Buy here for ${{ this.price }}</b-link>
      </b-card-text>
      <b-card-text>
        <b-link
          class="btn btn-primary"
          :href="'/gift/claim/' + this.gift.id"
          v-if="this.claimedStatus && !this.gift.purchaser_id"
        >Claim buying this gift.</b-link>
        <span v-if="this.claimedStatus && this.gift.purchaser_id">Claimed</span>
        <span v-if="this.gift.receiver">for {{ gift.receiver.name }}</span>
      </b-card-text>
      <b-card-text>
        <b-button v-if="gift.receiver" @click="unClaim(gift.id, $event)">Unclaim</b-button>
        <b-button
          v-if="currentUser && claimedStatus === false"
          @click="destroy(gift.id, $event)"
        >Delete</b-button>
        <b-link :href="'/gift/update/' + gift.id" v-if="currentUser && claimedStatus === false">Edit</b-link>
        <b-card-text v-if="gift.receiver" class="mt-4">
          <b-form style="display: flex;">
            <b-form-group class="mx-1">
              <b-form-checkbox name="purchased" v-model="purchased">Purchased?</b-form-checkbox>
            </b-form-group>
            <b-form-group class="mx-1">
              <b-form-checkbox name="received" v-model="received">Received?</b-form-checkbox>
            </b-form-group>
            <b-form-group class="mx-1">
              <b-form-checkbox name="wrapped" v-model="wrapped">Wrapped?</b-form-checkbox>
            </b-form-group>
            <b-form-group class="mx-1">
              <b-form-checkbox name="given" v-model="given">Given?</b-form-checkbox>
            </b-form-group>
          </b-form>
        </b-card-text>
      </b-card-text>
    </b-card>
  </div>
</template>
<script>
export default {
  props: [
    "title",
    "description",
    "price",
    "link",
    "claimedStatus",
    "gift",
    "unClaim",
    "destroy",
    "currentUser",
    "updateGift"
  ],
  data() {
    return {
      purchased: this.gift.purchased === 1,
      received: this.gift.received === 1,
      wrapped: this.gift.wrapped === 1,
      given: this.gift.given === 1
    };
  },
  watch: {
    purchased(newVal, oldVal) {
      console.log(newVal);
      this.updateGift({ ...this.gift, purchased: newVal });
    }
  }
};
</script>
