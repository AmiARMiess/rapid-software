<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Department {{ $department->name }} — Report</title>
  <style>
    @page { size: A4; margin: 20mm; }
    body { font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif; color: #0f172a; font-size: 12px; }
    header { position: fixed; top: 0; left: 0; right: 0; height: 60px; padding: 10px 20px; border-bottom: 1px solid #e6eef8; background: #fbfdff; }
    header .brand { display: flex; align-items: center; gap: 12px; }
    header h2 { margin: 0; font-size: 18px; color: #0b3a66; }
    header p { margin: 0; font-size: 11px; color: #475569; }

    footer { position: fixed; bottom: 0; left: 0; right: 0; height: 38px; padding: 6px 20px; border-top: 1px solid #e6eef8; font-size: 11px; color: #64748b; background: #fbfdff; }
    .page-number:before { content: 'Page ' counter(page); }

    main { margin-top: 80px; margin-bottom: 54px; }

    .top-row { display: flex; gap: 18px; align-items: stretch; margin-bottom: 18px; }
    .left { flex: 2; }
    .right { flex: 1; min-width: 180px; }

    .card { border-radius: 6px; padding: 12px; background: #fff; box-shadow: 0 1px 0 rgba(15,23,42,0.04); border: 1px solid #e6eef8; }
    .card h3 { margin: 0 0 8px 0; font-size: 12px; color: #0b3a66; text-transform: uppercase; letter-spacing: 0.04em; }
    .big { font-size: 28px; color: #06283d; font-weight: 700; }
    .muted { color: #64748b; font-size: 11px; }

    .details { margin-bottom: 14px; }
    .details dt { font-weight: 700; color: #0b3a66; font-size: 11px; }
    .details dd { margin: 0 0 8px 0; color: #0f172a; }

    .section { margin-bottom: 18px; }
    .section h4 { margin: 0 0 8px 0; font-size: 13px; color: #0b3a66; }

    .responsibilities { border-collapse: collapse; width: 100%; }
    .responsibilities th, .responsibilities td { text-align: left; padding: 8px 10px; border-bottom: 1px solid #eef2f7; }
    .responsibilities th { background: #f8fbff; color: #0b3a66; font-size: 11px; text-transform: uppercase; }

    /* make sure lists and pre-wrapped text print correctly */
    .description { white-space: pre-wrap; line-height: 1.45; }
  </style>
</head>
<body>
  <header>
    <div class="brand">
      <div>
        <h2>Company Name</h2>
        <p class="muted">Department Report</p>
      </div>
      <div style="margin-left:auto; text-align:right;">
        <p class="muted">Generated: {{ now()->format('d M Y H:i') }}</p>
        <p class="muted">Dept ID: {{ $department->id }}</p>
      </div>
    </div>
  </header>

  <footer>
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div class="muted">Confidential — Internal use only</div>
      <div class="muted page-number"></div>
    </div>
  </footer>

  <main>
    <div class="top-row">
      <div class="left">
        <div class="card">
          <div style="display:flex; align-items:center; width:100%; gap:16px;">
            <div style="flex:1;">
              <h3>Department</h3>
              <div style="font-size:16px; font-weight:700; color:#0b3a66;">{{ $department->name }}</div>
              <div class="muted">{{ optional($department->optionStatus)->name ?? 'Inactive' }}</div>
            </div>
          </div>
        </div>

        <div class="section">
          <h4>About</h4>
          <div class="card">
            <dl class="details">
              <dt>Created On</dt>
              <dd>{{ $department->created_at->format('d M Y') }}</dd>

              <dt>Description</dt>
              <dd class="description">{{ $department->description ?: 'No description provided.' }}</dd>
            </dl>
          </div>
        </div>
      </div>

      <div class="right">
        <div class="card" style="margin-bottom:12px;">
          <h3>Overview</h3>
          <div style="display:flex; flex-direction:column; gap:8px;">
            <div style="display:flex; justify-content:space-between;"><div class="muted">Total Positions</div><div>{{ $countTotalPosition }}</div></div>
            <div style="display:flex; justify-content:space-between;"><div class="muted">Total Employees</div><div>{{ $countTotalEmployee }}</div></div>
            <div style="display:flex; justify-content:space-between;"><div class="muted">Status</div><div>{{ optional($department->optionStatus)->name ?? 'Inactive' }}</div></div>
          </div>
        </div>

      </div>
    </div>

    <div class="section">
      <h4>Responsibilities</h4>
      <div class="card">
        @if($department->departmentResponsibles->isEmpty())
          <div class="muted">No responsibilities assigned.</div>
        @else
          <table class="responsibilities">
            <thead>
              <tr><th>#</th><th>Responsibility</th></tr>
            </thead>
            <tbody>
              @foreach ($department->departmentResponsibles as $i => $responsibility)
                <tr>
                  <td style="width:40px;">{{ $i + 1 }}</td>
                  <td>{{ $responsibility->name }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </main>
</body>
</html>