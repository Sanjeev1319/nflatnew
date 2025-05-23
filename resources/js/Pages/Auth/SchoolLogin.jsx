import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import LoginLayout from "@/Layouts/LoginLayout";
import { Head, Link, useForm } from "@inertiajs/react";

export default function Login({ status, canResetPassword }) {
	const { data, setData, post, processing, errors, reset } = useForm({
		school_uuid: "",
		password: "",
		remember: false,
	});

	const submit = (e) => {
		e.preventDefault();

		post(route("school.login"), {
			onFinish: () => reset("password"),
			onError: (errors) => {
				console.error("Login failed:", errors);
			},
		});
	};

	return (
		<LoginLayout formTitle={<>School Login</>}>
			<Head title="Log in" />

			{status && (
				<div className="mb-4 text-sm font-medium text-green-600">{status}</div>
			)}

			<form onSubmit={submit}>
				<div>
					<InputLabel htmlFor="school_uuid" value="School ID" />

					<TextInput
						id="school_uuid"
						type="text"
						name="school_uuid"
						value={data.school_uuid}
						className="mt-1 block w-full"
						autoComplete="username"
						isFocused={true}
						onChange={(e) => setData("school_uuid", e.target.value)}
					/>

					<InputError message={errors.school_uuid} className="mt-2" />
				</div>

				<div className="mt-4">
					<InputLabel htmlFor="password" value="Password" />

					<TextInput
						id="password"
						type="password"
						name="password"
						value={data.password}
						className="mt-1 block w-full"
						autoComplete="current-password"
						onChange={(e) => setData("password", e.target.value)}
					/>

					<InputError message={errors.password} className="mt-2" />
				</div>

				{/* <div className="mt-4 block">
					<label className="flex items-center">
						<Checkbox
							name="remember"
							checked={data.remember}
							onChange={(e) => setData("remember", e.target.checked)}
						/>
						<span className="ms-2 text-sm text-gray-600">Remember me</span>
					</label>
				</div> */}

				<div className="mt-4 flex items-center justify-end">
					{canResetPassword && (
						<Link
							href={route("password.request")}
							className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
						>
							Forgot your password?
						</Link>
					)}

					<PrimaryButton
						className="ms-4 mt-6"
						disabled={processing}
						type="submit"
					>
						Log in
					</PrimaryButton>
				</div>
			</form>
			<Link href={route("home")}>Go to Home Page</Link>
		</LoginLayout>
	);
}
