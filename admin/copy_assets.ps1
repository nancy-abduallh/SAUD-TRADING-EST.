$root = "c:\xampp\htdocs\SAUD-TRADING-EST"
$src  = "$root\src\assets"
$dst  = "$root\admin\uploads"

New-Item -ItemType Directory -Force "$dst\products","$dst\clients","$dst\sectors" | Out-Null
Copy-Item "$src\products\*" "$dst\products\" -Force
Copy-Item "$src\clients\*"  "$dst\clients\"  -Force
"food-sector.jpg","plastics-sector.jpg","hero-globe.jpg" | ForEach-Object {
    Copy-Item "$src\$_" "$dst\sectors\" -Force
}
Write-Host "Assets copied."