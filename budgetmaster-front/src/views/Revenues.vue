<template>
  <div>
    <AppHeader />
    <RevenueForm
      :revenueToEdit="revenueToEdit"
      @revenueAdded="fetchRevenues"
      @resetEdit="revenueToEdit = null"
    />
    <RevenueList
      :revenues="revenues"
      @editRevenue="revenueToEdit = $event"
      @deleteRevenue="deleteRevenue"
    />
  </div>
</template>

<script>
import RevenueForm from '../components/RevenueForm.vue';
import RevenueList from '../components/RevenueList.vue';
import AppHeader from '../components/AppHeader.vue';
import api from '../services/api';

export default {
  components: { RevenueForm, RevenueList, AppHeader },
  data() {
    return {
      revenues: [],
      revenueToEdit: null,
    };
  },
  methods: {
    async fetchRevenues() {
      try {
        const res = await api.get('/revenues');
        this.revenues = res.data;
      } catch (err) {
        console.error("Erreur lors du chargement des revenus :", err);
      }
    },
    async deleteRevenue(id) {
      if (confirm('Supprimer ce revenu ?')) {
        try {
          await api.delete(`/revenues/${id}`);
          this.fetchRevenues();
        } catch (err) {
          console.error("Erreur de suppression :", err);
        }
      }
    },
  },
  created() {
    this.fetchRevenues();
  },
};
</script>
