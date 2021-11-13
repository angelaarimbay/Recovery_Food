<template>
  <v-card>
    <strong>asdasdsadsadas</strong>

    <!-- then need mo dapat ng base 
    ngayon content na. 

    -->

    <v-container>
      <!-- lagay mo ngayon ung content mo -->
      <!-- lagay natin ung table sa template -->
      <v-data-table
        dense
        :headers="headers"
        :data="data"
        :items-per-page="5"
        class="table-striped border"
      >
      </v-data-table>
      <!-- need mo ung mga variables so add tayo JS -->
    </v-container>
  </v-card>
</template>
<script>
export default {
  data: () => ({
    data: [], //itong data na to nilalamanan from database.
    headers: [
      //ito columns
      { text: "Document Name", value: "type.name", align: "start" },
      { text: "Name", value: "name" },
      { text: "Document", value: "document" },
      { text: "Status", value: "status.name" },
      { text: "Actions", value: "id", sortable: false },
    ],
  }),
};
</script>