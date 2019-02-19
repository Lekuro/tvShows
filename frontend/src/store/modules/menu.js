export default {
  namespaced: true,
  state: {
    items: [
      {
        url: "/shows",
        text: "Show's List"
      },
      {
        url: "/login",
        text: "Login"
      },
      {
        url: "/registration",
        text: "Registration"
      }
    ]
  },
  getters: {
    items(state) {
      return state.items;
    }
  }
};
