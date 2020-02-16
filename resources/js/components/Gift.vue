<template>
  <div>
    <b-card :title="this.title" :sub-title="this.price" class="mt-2 mb-2">
      <b-card-text v-if="this.description">{{ this.description }}</b-card-text>
      <b-card-text>
        <b-link :href="this.link" v-if="this.link">Buy here for {{ this.price }}</b-link>
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
    </b-card>
  </div>
</template>
<script>
export default {
  props: ["title", "description", "price", "link", "claimedStatus", "gift"],
  mounted() {
    console.log(this.link);
  }
};
</script>
