import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';

export default function Show({ train }) {
    const { data, setData, put, processing, errors } = useForm({
        name: train.name || '',
        from: train.from || '',
        to: train.to || '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        put(route('trains.update', { train: train.id }), {
            onSuccess: () => {
                alert('Train updated successfully!');
            },
            onError: () => {
                alert('Failed to update train. Please check the input.');
            },
        });
    };

    return (
        <AuthenticatedLayout>
            <Head title="Edit Train" />

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
                    Edit Train
                </h2>

                <form onSubmit={handleSubmit}>
                    {/* Train Name */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="trainName"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            Train Name:
                        </label>
                        <input
                            type="text"
                            id="trainName"
                            value={data.name}
                            onChange={(e) => setData('name', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.name && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.name}
                            </div>
                        )}
                    </div>

                    {/* From */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="from"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            From:
                        </label>
                        <input
                            type="text"
                            id="from"
                            value={data.from}
                            onChange={(e) => setData('from', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.from && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.from}
                            </div>
                        )}
                    </div>

                    {/* To */}
                    <div style={{ marginBottom: '15px' }}>
                        <label
                            htmlFor="to"
                            style={{ display: 'block', marginBottom: '5px' }}
                        >
                            To:
                        </label>
                        <input
                            type="text"
                            id="to"
                            value={data.to}
                            onChange={(e) => setData('to', e.target.value)}
                            style={{
                                width: '100%',
                                padding: '10px',
                                borderRadius: '4px',
                                border: '1px solid #ccc',
                            }}
                            required
                        />
                        {errors.to && (
                            <div style={{ color: 'red', marginTop: '5px' }}>
                                {errors.to}
                            </div>
                        )}
                    </div>

                    {/* Submit Button */}
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
                        {processing ? 'Saving...' : 'Save Changes'}
                    </button>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
