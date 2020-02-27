<template>
  <div>
    <t-card :header="this.title" class="mt-2 mb-2">
      <p v-if="this.description">{{ description }}</p>
      <a :href="this.link" v-if="this.link">Buy here for ${{ this.price }}</a>
      <a
        class="btn btn-primary"
        :href="'/gift/claim/' + this.gift.id"
        v-if="this.claimedStatus && !this.gift.purchaser_id"
      >Claim buying this gift.</a>
      <span v-if="this.claimedStatus && this.gift.purchaser_id">Claimed</span>
      <span v-if="this.gift.receiver">for {{ gift.receiver.name }}</span>
      <div>
        <t-button
          primary-class="color-indigo-500"
          size="sm"
          v-if="gift.receiver"
          @click="unClaim(gift.id, $event)"
        >Unclaim</t-button>
        <t-button
          v-if="currentUser && claimedStatus === false"
          @click="destroy(gift.id, $event)"
        >Delete</t-button>
        <a :href="'/gift/update/' + gift.id" v-if="currentUser && claimedStatus === false">Edit</a>
        <form v-if="gift.receiver" style="display: flex;">
          <label>
            <t-checkbox name="purchased" v-model="purchased" />Purchased?
          </label>
          <label>
            <t-checkbox name="received" v-model="received" />Received?
          </label>
          <label>
            <t-checkbox name="wrapped" v-model="wrapped" />Wrapped?
          </label>
          <label>
            <t-checkbox name="given" v-model="given" />Given?
          </label>
        </form>
      </div>
    </t-card>
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
      this.updateGift({ ...this.gift, purchased: newVal });
    }
  }
};
</script>
