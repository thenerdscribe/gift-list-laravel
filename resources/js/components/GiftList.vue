<template>
  <div>
    <b-form v-if="this.parsedGifts && this.filter" @submit="giftSearch">
      <b-form-group id="input-group-search" label="Search gifts" label-for="search">
        <b-form-input id="search" v-model="searchValue" type="text" placeholder="Search for gift"></b-form-input>
      </b-form-group>
      <b-button @click="clearSearch">Clear Search</b-button>
      <b-button type="submit">Search Gifts</b-button>
    </b-form>
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
      this.$http
        .get(`/gift/search/?searchQuery=${this.searchValue}&user=${receiver}`)
        .then(async response => {
          const data = await response.json();
          const filteredGifts = data.filter(gift => gift[this.filter] == user);
          this.localGifts = filteredGifts;
        });
    },
    clearSearch() {
      this.searchValue = "";
      const user = this.parsedGifts[0].receiver_id;
      this.$http
        .get(`/gift/search/?searchQuery=&user=${user}`)
        .then(async response => {
          const data = await response.json();
          this.localGifts = data;
        });
    },
    unClaim(giftId, event) {
      event.preventDefault();
      this.$http.patch(`/gift/unclaim/${giftId}`).then(async response => {
        const data = await response.json();
        this.localGifts = data;
      });
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
