import { ref } from '@vue/reactivity';
import axios from 'axios';

const getSupplierDetails = () => {
    const supplier = ref({});
    const supplierError = ref({});

    const getEditData = async (id) => {
        await axios.get('api/supplier/getSupplierEdit/' + id, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`,
                Accept: 'application/json',
            }
        }).then((res) => {
            supplier.value = res.data;
        }).catch((resErr) => {
            supplierError.value = resErr;
        })

    }
    return { supplier, supplierError, getEditData }
}
export default getSupplierDetails;
