<template>
  <div>
    <form v-if="this.parsedGifts && this.filter" @submit="giftSearch">
      <t-input id="search" v-model="searchValue" type="text" placeholder="Search for gift" />
      <t-button @click="clearSearch">Clear Search</t-button>
      <t-button type="submit">Search Gifts</t-button>
    </form>
    <ul class="gift-list">
      <li v-bind:key="gift.id" v-for="gift in this.parsedGifts">
        <gift
          :title="gift.title"
          :description="gift.description"
          :price="gift.price"
          :link="gift.url"
          :claimedStatus="parsedClaims"
          :gift="gift"
          :unClaim="unClaim"
          :destroy="destroy"
          :currentUser="user"
          :updateGift="updateGift"
        ></gift>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ["gifts", "showClaims", "user", "filter"],
  data() {
    return {
      localGifts: this.gifts,
      searchValue: ""
    };
  },
  methods: {
    giftSearch(e) {
      e.preventDefault();
      const receiver = this.parsedGifts[0].receiver_id;
      const user = this.parsedGifts[0][this.filter];
      window.axios
        .get(`/gift/search/?searchQuery=${this.searchValue}&user=${receiver}`)
        .then(async response => {
          const filteredGifts = response.data.filter(
            gift => gift[this.filter] == user
          );
          this.localGifts = filteredGifts;
        });
    },
    clearSearch() {
      this.searchValue = "";
      const user = this.parsedGifts[0].receiver_id;
      window.axios
        .get(`/gift/search/?searchQuery=&user=${user}`)
        .then(async response => {
          this.localGifts = response.data;
        });
    },
    unClaim(giftId, event) {
      event.preventDefault();
      window.axios.patch(`/gift/unclaim/${giftId}`).then(async response => {
        this.localGifts = response.data;
      });
    },
    destroy(giftId, event) {
      event.preventDefault();
      window.axios.delete(`/gift/${giftId}`).then(async response => {
        this.localGifts = response.data;
      });
    },
    updateGift(gift, event) {
      window.axios.patch(`/gift/${gift.id}`, gift);
    }
  },
  computed: {
    parsedGifts() {
      var gifts;
      if (typeof this.localGifts === "string") {
        gifts = JSON.parse(this.localGifts);
      } else {
        gifts = this.localGifts;
      }
      return gifts.sort((a, b) => Number(a.price) > Number(b.price));
    },
    parsedClaims() {
      return JSON.parse(this.showClaims);
    }
  }
};
</script>
