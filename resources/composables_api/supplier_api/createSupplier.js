import { ref } from '@vue/reactivity';
import axios from 'axios';


const registerSupplier = () => {
    const supplier = ref({});
    const loading = ref(true);
    const supplierError = ref({});


    const createSupplier = async (form) => {
        await axios.post('api/supplier/supplierCreate', form, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            supplier.value = res.data;
            loading.value = false;
        }).catch((resErr) => {
            supplierError.value = resErr;
            loading.value = false;
        })
    }
    return { supplier,loading, supplierError, createSupplier }
}
export default registerSupplier;

