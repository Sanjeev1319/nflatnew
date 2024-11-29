import ApplicationLogo from "@/Components/ApplicationLogo";
import { Link } from "@inertiajs/react";

export default function GuestLayout({ children }) {
	return (
		<div className="flex min-h-screen flex-col items-center bg-gray-100 pt-6">
			<div>
				<Link href="/">
					<ApplicationLogo className="h-20 w-20 fill-current text-gray-500" />
				</Link>
			</div>

			<div className="lg:w-9/12 md:w-10/12 w-full">{children}</div>
		</div>
	);
}
