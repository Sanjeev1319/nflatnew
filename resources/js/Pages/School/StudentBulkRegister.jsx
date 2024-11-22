import { useState } from "react";
import { Link, useForm } from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function StudentBulkRegister({
	import_errors = [],
	success_message,
}) {
	const { data, setData, post, errors, reset, setError } = useForm({
		file: null, // Add file to the data state
	});

	const [message, setMessage] = useState("");
	const [validationErrors, setValidationErrors] = useState([]); // For row-specific errors

	// Handle file change
	const handleFileChange = (e) => {
		setData("file", e.target.files[0]);
	};

	const handleSubmit = (e) => {
		e.preventDefault();

		if (!data.file) {
			setMessage("Please select a file to upload.");
			return;
		}

		// POST request to upload file
		post(route("upload-students"), data, {
			onSuccess: (response) => {
				setMessage(response.message || "File uploaded successfully.");
				reset(); // Reset form fields
			},
			onError: (response) => {
				setMessage("An error occurred during file upload.");
				reset(); // Reset form fields
			},
		});
	};

	return (
		<AuthenticatedLayout
			header={
				<h2 className="text-xl font-semibold leading-tight text-gray-800">
					Student Bulk Registration
				</h2>
			}
		>
			<Head title="Dashboard" />

			<div className="py-12">
				<div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
					<div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
						<div className="p-6 text-gray-900">
							<h3>Upload Student Details</h3>
							<form onSubmit={handleSubmit}>
								{/* File Input */}
								<TextInput
									type="file"
									name="file"
									onChange={handleFileChange}
									accept=".xlsx, .csv"
								/>
								<PrimaryButton type="submit">Upload</PrimaryButton>
							</form>

							<div>
								<a
									href="/storage/samples/student_bulk_register.xlsx"
									download
									className="text-green-700 underline hover:text-green-900 hover:font-semibold"
								>
									Click Here to Download the Sample file
								</a>
							</div>

							{/* Message Display */}
							{message && <p className="text-red-500">{message}</p>}
							{/* Validation Errors */}
							{/* {import_errors && import_errors.length > 0 && (
								<div className="mt-6">
									<h4 className="text-red-500 font-bold">
										Errors in Uploaded File:
									</h4>
									<table className="min-w-full border-collapse border border-gray-200">
										<thead>
											<tr>
												<th className="border border-gray-300 px-4 py-2">
													Row
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Name
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Class
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Section
												</th>
												<th className="border border-gray-300 px-4 py-2">
													DOB
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Gender
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Parent Name
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Parent Email
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Parent Mobile
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Errors
												</th>
											</tr>
										</thead>
										<tbody>
											{import_errors.map((error, index) => (
												<tr key={index}>
													<td className="border border-gray-300 px-4 py-2 text-center">
														{error.row}
													</td>
													<td className="border border-gray-300 px-4 py-2">
														{error.data.name || "N/A"}
													</td>
													<td className="border border-gray-300 px-4 py-2">
														{error.data.class || "N/A"}
													</td>
													<td className="border border-gray-300 px-4 py-2">
														{error.data.section || "N/A"}
													</td>
													<td className="border border-gray-300 px-4 py-2">
														{error.data.dob || "N/A"}
													</td>
													<td className="border border-gray-300 px-4 py-2">
														{error.data.gender || "N/A"}
													</td>
													<td className="border border-gray-300 px-4 py-2">
														{error.data.parent_name || "N/A"}
													</td>
													<td className="border border-gray-300 px-4 py-2">
														{error.data.parent_email || "N/A"}
													</td>
													<td className="border border-gray-300 px-4 py-2">
														{error.data.parent_mobile || "N/A"}
													</td>
													<td className="border border-gray-300 px-4 py-2 text-red-500">
														<ul className="list-disc list-inside">
															{error.errors.map((err, idx) => (
																<li key={idx}>{err}</li>
															))}
														</ul>
													</td>
												</tr>
											))}
										</tbody>
									</table>
								</div>
							)} */}
							{import_errors && import_errors.length > 0 && (
								<div className="mt-6">
									<h4 className="text-red-500 font-bold">
										Errors in Uploaded File:
									</h4>
									<table className="min-w-full border-collapse border border-gray-200">
										<thead>
											<tr>
												<th className="border border-gray-300 px-4 py-2">
													Row
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Data
												</th>
												<th className="border border-gray-300 px-4 py-2">
													Errors
												</th>
											</tr>
										</thead>
										<tbody>
											{import_errors.map((error, index) => (
												<tr key={index}>
													<td className="border border-gray-300 px-4 py-2 text-center">
														{error.row}
													</td>
													<td className="border border-gray-300 px-4 py-2">
														<pre className="text-sm">
															{Object.entries(error.data).map(
																([key, value]) => (
																	<div key={key}>
																		<strong>{key}:</strong> {value || "N/A"}
																	</div>
																)
															)}
														</pre>
													</td>
													<td className="border border-gray-300 px-4 py-2 text-red-500">
														<ul className="list-disc list-inside">
															{error.errors.map((err, idx) => (
																<li key={idx}>{err}</li>
															))}
														</ul>
													</td>
												</tr>
											))}
										</tbody>
									</table>
								</div>
							)}
						</div>
					</div>
				</div>
			</div>
		</AuthenticatedLayout>
	);
}
