import axios from 'axios';

export const posting = (url, data={}) => {
    return axios.post(
        url,
        data,
        {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        }
    );
}
