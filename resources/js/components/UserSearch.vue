<template>
  <div>
    <b-form @submit="searchUsers">
      <b-form-group id="input-group-search" label="Search Users" label-for="search">
        <b-form-input
          id="search"
          v-model="searchValue"
          type="text"
          required
          placeholder="Search for someone"
        ></b-form-input>
      </b-form-group>
      <b-button type="submit" variant="primary">Search</b-button>
    </b-form>
    <ul>
      <li :key="user.id" v-for="user in users">
        <a :href="'/user/' + user.id">{{user.name}}</a>
      </li>
    </ul>
    <div v-if="cameBackBlank">
      <p>No results</p>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      searchValue: "",
      users: [],
      cameBackBlank: false
    };
  },
  methods: {
    searchUsers(e) {
      e.preventDefault();
      this.cameBackBlank = false;
      this.$http
        .get(`/user/search?searchTerm=${this.searchValue}`)
        .then(async response => {
          const data = await response.json();
          if (data.length === 0) {
            this.cameBackBlank = true;
          }
          this.users = data;
        });
    }
  }
};
</script>
