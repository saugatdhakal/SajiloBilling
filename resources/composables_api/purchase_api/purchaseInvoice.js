import axios from 'axios';
import { ref } from 'vue';

const purchaseInvoice = () => {
    const invoiceNumber = ref();
    const getInvoiceNumber = async() => {
      await  axios.get('/api/purchase/purchaseInvoice', {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            invoiceNumber.value = res.data;
        })
    }
    return { getInvoiceNumber, invoiceNumber };
}

export default purchaseInvoice;
