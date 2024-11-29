export default function LoginLayout({ children }) {
	return (
		<>
			<div class="bg-white flex flex-col min-h-[900px]">
				<div class="flex-1 min-h-full flex">
					<div class="py-12 px-4 justify-center flex flex-col flex-1 lg:px-20 lg:flex-none sm:px-6">
						<div class="lg:w-96 max-w-96 w-full mx-auto">
							<div>
								<img
									alt="Your Company"
									src={"/storage/ncfe_logos/nflat_logo.png"}
									class="w-auto h-10"
								/>
								<h2 className="text-gray-900 tracking-tighter font-bold text-2xl leading-9 mt-8 text-center">
									NFLAT
								</h2>
								<div className="mt-10">
									<div> {children} </div>
								</div>
							</div>
						</div>
					</div>
					<div class="lg:block flex-1 w-0 hidden relative"></div>
				</div>
			</div>
		</>
	);
}
