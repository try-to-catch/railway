import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function EditCarriage({ trains, carriage }) {
    const { data, setData, put, processing, errors } = useForm({
        number: carriage.number,
        class: carriage.class,
        train_id: carriage.train_id,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('trains.carriages.update', carriage.id), {
            onSuccess: () => {
                alert('Carriage updated successfully!');
            },
            onError: () => {
                alert('Failed to update carriage. Please check the input.');
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Edit Carriage" />

            <div
                style={{
                    maxWidth: '600px',
                    margin: '20px auto',
                    padding: '20px',
                    border: '1px solid #ccc',
                    borderRadius: '8px',
                    backgroundColor: '#f8f9fa',
                }}
            >
                <h2 style={{ textAlign: 'center', marginBottom: '20px' }}>
                    Edit Carriage {carriage.number}
                </h2>
                <form onSubmit={handleSubmit}>
                    {/* Number */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="number"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Carriage Number:
                        </label>
                        <input
                            type="text"
                            id="number"
                            value={data.number}
                            onChange={(e) => setData('number', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.number && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.number}
                            </div>
                        )}
                    </div>

                    {/* Class */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="class"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Class:
                        </label>
                        <input
                            type="text"
                            id="class"
                            value={data.class}
                            onChange={(e) => setData('class', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.class && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.class}
                            </div>
                        )}
                    </div>

                    {/* Train Selection */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="train"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Select Train:
                        </label>
                        <select
                            id="train"
                            value={data.train_id}
                            onChange={(e) => setData('train_id', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        >
                            {trains.map((train) => (
                                <option key={train.id} value={train.id}>
                                    {train.name}
                                </option>
                            ))}
                        </select>
                        {errors.train_id && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.train_id}
                            </div>
                        )}
                    </div>

                   
                    <button
                        type="submit"
                        disabled={processing}
                        style={{
                            display: 'block',
                            width: '100%',
                            padding: '10px',
                            backgroundColor: '#007bff',
                            color: '#fff',
                            border: 'none',
                            borderRadius: '4px',
                            cursor: processing ? 'not-allowed' : 'pointer',
                        }}
                    >
                        {processing ? 'Updating...' : 'Update Carriage'}
                    </button>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
