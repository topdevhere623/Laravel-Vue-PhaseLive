<template>
  <div>
    <ph-panel>
      <table v-if="invoices" cellspacing="10">
        <thead>
          <tr>
            <td>Date</td>
            <td>Payment</td>
            <td>Status</td>
            <td>Invoice</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="invoice in invoices.data">
            <td>{{ invoiceDate(invoice) }}</td>
            <td>{{ amountPaid(invoice) }}</td>
            <td>{{ invoice.paid ? "Paid" : "Outstanding" }}</td>
            <td><a class="view_link" :href="invoice.invoice_pdf">View</a></td>
          </tr>
        </tbody>
      </table>
      <div v-else>
        You do not have any invoices.
      </div>
    </ph-panel>
  </div>
</template>

<script>
import { UserEvents } from "events";

export default {
  name: "invoices",

  data() {
    return {
      invoices: null,
    };
  },

  created() {
    UserEvents.$emit("updateTitle", "Billing");
    this.getInvoices();
  },

  methods: {
    invoiceDate(invoice) {
      return moment.unix(invoice.created).format("DD/MM/YYYY");
    },
    amountPaid(invoice) {
      const formatter = new Intl.NumberFormat("en-GB", {
        style: "currency",
        currency: "GBP",
        maximumSignificantDigits: 2,
      });
      return formatter.format(invoice.amount_due / 100);
    },
    async getInvoices() {
      await axios.get("/api/account/invoices").then((response) => {
        this.invoices = response.data;
      });
    },
  },
};
</script>

<style lang="scss" scoped>
table {
  width: 100%;
  thead {
    tr {
      td {
        font-weight: bold;
      }
    }
  }
  tr {
    td {
      padding: 10px;

      .view_link {
        color: #3300ff;
      }
    }
  }
}
</style>
