<template>
  <div>
    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
      <b-form-group id="input-group-title" label="Gift Title" label-for="title">
        <b-form-input
          id="title"
          v-model="form.title"
          description="What is your gift called?"
          type="text"
          required
          placeholder="Enter gift"
        ></b-form-input>
      </b-form-group>
      <b-form-group id="input-group-price" label="Price" label-for="price">
        <b-form-input
          id="price"
          v-model="form.price"
          type="number"
          step="any"
          placeholder="Enter price"
        ></b-form-input>
      </b-form-group>
      <b-form-group
        id="input-group-description"
        label="Description"
        label-for="price"
        description="Fill out any additional info about the gift"
      >
        <b-form-input
          id="description"
          v-model="form.description"
          type="text"
          placeholder="Enter description"
        ></b-form-input>
      </b-form-group>
      <b-form-group id="input-group-link" label="Link" label-for="link">
        <b-form-input
          id="link"
          v-model="form.url"
          type="text"
          placeholder="Paste in a URL to the product"
        ></b-form-input>
      </b-form-group>
      <b-button type="submit" variant="primary">Submit</b-button>
    </b-form>
    <b-alert :show="status" dismissible variant="success">
      <p>Successfully {{ verb }} gift!</p>
    </b-alert>
    <b-alert :show="status === false" dismissible variant="danger">
      <p>Error in submitting your gift.</p>
    </b-alert>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: ["gift", "url", "method", "purchaser", "receiver", "elseAdded"],
  data() {
    return {
      status: null,
      form: {
        title: "",
        price: "",
        description: "",
        url: "",
        purchaser: this.purchaser,
        receiver: this.receiver,
        someone_else_added: this.elseAdded
      },
      show: true
    };
  },
  mounted() {
    console.log(this.gift);
    if (this.parsedGift) {
      this.form.title = this.parsedGift.title;
      this.form.price = this.parsedGift.price;
      this.form.description = this.parsedGift.description;
      this.form.url = this.parsedGift.url;
    }
  },
  computed: {
    parsedGift() {
      if (this.gift) {
        return JSON.parse(this.gift);
      }
    },
    verb() {
      const verb = this.method === "post" ? "added" : "updated";
      return verb;
    }
  },
  methods: {
    onSubmit(evt) {
      evt.preventDefault();
      axios({ url: this.url, method: this.method, data: this.form })
        .then(() => {
          if (this.method === "post") {
            this.onReset(evt);
          }
          this.$nextTick(() => {
            this.show = true;
            this.status = true;
          });
        })
        .catch(e => (this.status = false));
    },
    onReset(evt) {
      evt.preventDefault();
      // Reset our form values
      this.form.title = "";
      this.form.price = "";
      this.form.description = "";
      this.form.url = "";
      // Trick to reset/clear native browser form validation state
      this.show = false;
    }
  }
};
</script>
